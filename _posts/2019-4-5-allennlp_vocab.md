---
layout: post
title: Vocabulary in Allennlp
excerpt: tldr; always include test in your config.
---

I've been using [allennlp](https://github.com/allenai/allennlp/) a lot lately, and I have found it to be immensely 
valuable. As with any library, there are several tricks you need to know, and I came across something recently that
I wanted to make a note of (perhaps mainly for myself).

Long story short, the question is: should you include your test data in your vocabulary? In principle, the answer is 
No, because test data should be completely unseen. Ideally, if a test token is present in your pre-trained embeddings, then it 
should be retrieved, otherwise, it should become an UNK token and get an UNK embedding.

In an allennlp config file (for example, see [here](https://github.com/allenai/allennlp/blob/master/training_config/ner.jsonnet)), you are required to give 
paths for `train_data_path` and `validation_data_path`, and you _may_ 
give a path fo `test_data_path`. All datasets given in the config are used when creating the 
vocabulary. For example, in [this file](https://github.com/allenai/allennlp/blob/master/training_config/ner.jsonnet) 
the test data is included in the vocabulary.

But here's the thing: in allennlp, if you do *not* include the `test_data_path` key in your config, then every word
not in the vocabulary maps to UNK, _whether or not it is present in the embeddings_. For example, perhaps a relatively
frequent word such as `conversation` (for which you have an embedding) is in test, but not in train or dev. This word will
be mapped to UNK, which is counter-intuitive. 

You can specify pre-trained files
in a vocabulary key in the config, but this doesn't solve the issue either. As far as I know, if you want test tokens
to be properly retrieved from the pre-trained embeddings, the _only way_ to do it is to include the test data in your config.

Note: if you fine-tune embeddings at train time, it's not clear what to do at test time. For a word not present in train, it may not
make sense to select from the untuned lookup table. Then again, maybe this is better than mapping to UNK.

The badge below will take you to a minimal code sample you can play with.

[![Binder](https://mybinder.org/badge_logo.svg)](https://mybinder.org/v2/gist/mayhewsw/3ced494825fa65378464cbf268325b58/master)
