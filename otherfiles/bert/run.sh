wget -c https://raw.githubusercontent.com/mayhewsw/mayhewsw.github.io/master/otherfiles/bert/bert_classifier.py
wget -c https://raw.githubusercontent.com/mayhewsw/mayhewsw.github.io/master/otherfiles/bert/ner.json
wget -c https://raw.githubusercontent.com/mayhewsw/mayhewsw.github.io/master/otherfiles/bert/bert_ner.json

mkdir -p mylib
mv bert_classifier.py mylib

export NER_TRAIN_DATA_PATH=/path/to/conll.train
export NER_TEST_A_PATH=/path/to/conll.testa
export NER_TEST_B_PATH=/path/to/conll.testb


# This is the setup from the BERT paper
# Classification layer with fine-tuned BERT
# This should get ~92
export MODEL=bert_classifier
export FINE_TUNE_BERT=true
export TOP_LAYER_ONLY=false

SER=bert-linear-finetune-alllayer
rm -rf $SER
allennlp train bert_ner.json --include-package mylib -s $SER


# This is Nelson Liu's setup
# Classification layer WITHOUT fine-tuned BERT
# This should get ~84
export MODEL=bert_classifier
export FINE_TUNE_BERT=false
export TOP_LAYER_ONLY=true

SER=bert-linear-finetune-alllayer
rm -rf $SER
allennlp train bert_ner.json --include-package mylib -s $SER


# This is Joel Grus' setup
# CRF layer WITHOUT fine-tuned BERT
# This should get ~92
export MODEL=crf_tagger
export FINE_TUNE_BERT=false
export TOP_LAYER_ONLY=true

SER=bert-linear-finetune-alllayer
rm -rf $SER
allennlp train bert_ner.json --include-package mylib -s $SER
