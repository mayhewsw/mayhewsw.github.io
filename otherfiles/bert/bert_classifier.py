from typing import Dict, List, Any, Optional

from allennlp.modules.token_embedders import PretrainedBertEmbedder, BertEmbedder
from overrides import overrides
from allennlp.models.model import Model
import torch
from torch.nn.modules.linear import Linear
from allennlp.training.metrics import CategoricalAccuracy, SpanBasedF1Measure
from allennlp.modules import TextFieldEmbedder, FeedForward
import allennlp.nn.util as util
import torch.nn.functional as F
from allennlp.data import Vocabulary
from allennlp.nn import Activation


@Model.register("bert_classifier")
class BERTClassifier(Model):
    """
    This is intended to be a simple classifier that uses BERT embeddings. Just
    a linear classification layer over the pre-trained BERT representation.
    """

    def __init__(self, vocab: Vocabulary,
                 text_field_embedder: TextFieldEmbedder,
                 label_namespace: str = "labels",
                 label_encoding: Optional[str] = None,
                 calculate_span_f1: bool = None,
                 dropout: Optional[float] = None,
                 verbose_metrics: bool = False,
                 ) -> None:
        super().__init__(vocab)
        self._embedder = text_field_embedder

        self.num_tags = self.vocab.get_vocab_size("labels")
        self.calculate_span_f1 = calculate_span_f1
        self._verbose_metrics = verbose_metrics

        if dropout:
            self.dropout = torch.nn.Dropout(dropout)
        else:
            self.dropout = None

        output_dim = self._embedder.get_output_dim()
        self.tag_projection_layer = Linear(output_dim, self.num_tags)

        self.label_namespace = label_namespace
        self._f1_metric = SpanBasedF1Measure(vocab,
                                             tag_namespace=label_namespace,
                                             label_encoding=label_encoding)

    @overrides
    def forward(self,  # type: ignore
                tokens: Dict[str, torch.LongTensor],
                tags: torch.LongTensor = None,
                metadata: List[Dict[str, Any]] = None,  # pylint: disable=unused-argument
                **kwargs) -> Dict[str, torch.Tensor]:

        embedded_text_input = self._embedder(tokens)
        mask = util.get_text_field_mask(tokens)

        # print(offsets.shape)
        # print(embedded_text_input.shape)

        if self.dropout:
            embedded_text_input = self.dropout(embedded_text_input)

        logits = self.tag_projection_layer(embedded_text_input)

        batch_size, sequence_length_wordpiece, _ = embedded_text_input.size()

        reshaped_log_probs = logits.view(-1, self.num_tags)
        # shape: (batch_size, sequence_length_wordpiece, num_tags)
        class_probabilities = F.softmax(reshaped_log_probs, dim=-1).view([batch_size, sequence_length_wordpiece, self.num_tags])
        # shape: (batch_size, sequence_length_wordpiece)
        predicted_tags = torch.argmax(class_probabilities, dim=2)

        output_dict = {"tags": predicted_tags}

        if tags is not None:

            output_dict["gold_tags"] = tags

            batch_size, max_seq_len = tags.shape

            loss = util.sequence_cross_entropy_with_logits(logits, tags, mask)

            # Represent tags as "class probabilities" that we can feed into the metrics
            class_probabilities = torch.zeros(batch_size, max_seq_len, self.num_tags)
            for i, instance_tags in enumerate(predicted_tags):
                for j, tag_id in enumerate(instance_tags):
                    class_probabilities[i, j, tag_id] = 1

            if self.calculate_span_f1:
                self._f1_metric(class_probabilities, tags, tokens["mask"])

            output_dict["loss"] = loss

            if metadata is not None:
                output_dict["words"] = [x["words"] for x in metadata]

        return output_dict

    @overrides
    def decode(self, output_dict: Dict[str, torch.Tensor]) -> Dict[str, torch.Tensor]:
        """
        Converts the tag ids to the actual tags.
        ``output_dict["tags"]`` is a list of lists of tag_ids,
        so we use an ugly nested list comprehension.
        """
        output_dict["tags"] = [
            [self.vocab.get_token_from_index(tag.item(), namespace=self.label_namespace)
             for tag in instance_tags]
            for instance_tags in output_dict["tags"]
        ]

        if "gold_tags" in output_dict:
            output_dict["gold_tags"] = [
                [self.vocab.get_token_from_index(tag.item(), namespace=self.label_namespace)
                 for tag in instance_tags]
                for instance_tags in output_dict["gold_tags"]
            ]

        return output_dict

    @overrides
    def get_metrics(self, reset: bool = False) -> Dict[str, float]:
        # metrics_to_return = {metric_name: metric.get_metric(reset) for
        #                     metric_name, metric in self.metrics.items()}
        metrics_to_return = {}
        if self.calculate_span_f1:
            f1_dict = self._f1_metric.get_metric(reset=reset)
            if self._verbose_metrics:
                metrics_to_return.update(f1_dict)
            else:
                metrics_to_return.update({
                    x: y for x, y in f1_dict.items() if
                    "overall" in x})
        return metrics_to_return
