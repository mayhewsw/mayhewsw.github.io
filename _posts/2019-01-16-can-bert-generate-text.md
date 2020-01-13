---
layout: post
title: Can you use BERT to generate text?
excerpt: No.
comments: true
---

Just quickly wondering if you can use [BERT](https://arxiv.org/abs/1810.04805) to generate text. I'm using [huggingface's pytorch pretrained BERT model](https://github.com/huggingface/pytorch-pretrained-BERT/) (thanks!). I know BERT isn't designed to generate text, just wondering if it's possible. It's trained to predict a masked word, so maybe if I make a partial sentence, and add a fake mask to the end, it will predict the next word. As a first pass on this, I'll give it a sentence that has a dead giveaway last token, and see what happens. 

My test sentence was: 
```
although he had already eaten a large meal, he was still very hungry.
```

First, I masked "hungry" just to make sure it worked. No problem. The first option was "hungry", and the next few highly ranked options were also plausible. But notice the period at the end. If you are generating text, you only have left context. You can't rely on the rest of the sentence. So, the next experiment was to remove the period.

```
although he had already eaten a large meal, he was still very hungry
```

As before, I masked "hungry" to see what BERT would predict. If it could predict it correctly without any right context, we might be in good shape for generation.

This failed. BERT predicted "much" as the last word. Maybe this is because BERT thinks the absence of a period means the sentence should continue. Maybe it's just so used to complete sentences it gets confused. I'm not sure.

One might argue that we should continue predicting after "much". Maybe it's going to produce something meaningful. To that I would say: first, this was meant to be a dead giveaway, and any human would predict "hungry". Second, I tried it, and it keeps predicting dumb stuff. After "much", the next token is ",".

So, at least using these trivial methods, BERT can't generate text. That said, the [Transformer-Decoder](https://github.com/huggingface/pytorch-openai-transformer-lm) from OpenAI does generate text very nicely.

Here's my experimental code:

```python
import torch
from pytorch_pretrained_bert import BertTokenizer, BertModel, BertForMaskedLM

# Load pre-trained model tokenizer (vocabulary)
modelpath = "bert-base-uncased"
tokenizer = BertTokenizer.from_pretrained(modelpath)

text = "dummy. although he had already eaten a large meal, he was still very hungry."
target = "hungry"
tokenized_text = tokenizer.tokenize(text)

# Mask a token that we will try to predict back with `BertForMaskedLM`
masked_index = tokenized_text.index(target)
tokenized_text[masked_index] = '[MASK]'

# Convert token to vocabulary indices
indexed_tokens = tokenizer.convert_tokens_to_ids(tokenized_text)
# Define sentence A and B indices associated to 1st and 2nd sentences (see paper)
segments_ids = [1] * len(tokenized_text)
# this is for the dummy first sentence. 
segments_ids[0] = 0
segments_ids[1] = 0

# Convert inputs to PyTorch tensors
tokens_tensor = torch.tensor([indexed_tokens])
segments_tensors = torch.tensor([segments_ids])
# Load pre-trained model (weights)
model = BertForMaskedLM.from_pretrained(modelpath)
model.eval()

# Predict all tokens
predictions = model(tokens_tensor, segments_tensors)
predicted_index = torch.argmax(predictions[0, masked_index]).item()
predicted_token = tokenizer.convert_ids_to_tokens([predicted_index])

print("Original:", text)
print("Masked:", " ".join(tokenized_text))

print("Predicted token:", predicted_token)
print("Other options:")
# just curious about what the next few options look like.
for i in range(10):
    predictions[0,masked_index,predicted_index] = -11100000
    predicted_index = torch.argmax(predictions[0, masked_index]).item()
    predicted_token = tokenizer.convert_ids_to_tokens([predicted_index])
    print(predicted_token)

```
