---
layout: page
title: Cross-lingual Transfer of Named Entity Recognizers without Parallel Corpora
comments: true
---

I recently came across this paper: [Cross-lingual Transfer of Named Entity Recognizers
without Parallel Corpora](http://www.aclweb.org/anthology/P15-2064), by Ayah Zirikly and Masato Hagiwara, published in IJCNLP, 2015. It's very related to [my research](http://aclweb.org/anthology/D/D17/D17-1268.pdf), so I wanted to write a short review. 

The paper is about NER for e-commerce, and is motivated by the standard low-resource motivations: not enough annotated data, not much parallel data either. The proposed solution is a transfer model, with the main innovations being gazetteer expansion and automatically mapped Brown clusters.

* _Gazetteer expansion_: this technique exploits the fact that names are often spelled identically across languages. They learn word2vec models in each language, and use identically spelled names as anchor points between the semantic spaces. They use graph propagation with gazetteer entries as nodes, and edge weights proportional to word2vec distances.

* _Automatically mapped Brown clusters_: Brown cluster IDs are good features for NER, but they are language specific. In a cross-lingual setting, the question is how to map IDs between languages. They address this by greedily mapping clusters by two different metrics of cluster similarity. The first is simple Levenshtein distance, the second is based on BabelNet synsets. Their method allows that the mapping can be many to one, and one to many. 

The gazetteer expansion seems prone to noise, since there is no guarantee that nearby neighbors in the semantic space are actually named entities. The Brown cluster mapping is a good idea, and one that should be explored more. Perhaps a graph propagation algorithm similar to the gazetteer expansion would work. 

All of their results come from in-house product datasets from Rakuten.com with six tags: Color, Brand, Material, Model, Type, Size. There is very little detail on how these were created or annotated, so results need to be taken with a grain of salt. They trained on a relatively small amount of in-house English training data. Their target languages are Spanish and Chinese, which are arguably not low-resource languages (except maybe in this domain). 

One interesting result is their baseline. They use Bing Translate to translate the target language test data into English, run a standard English model, then use the word alignments to map the labels back (note: I didn't know that Bing Translate returned alignments. Good to know.) The interesting thing is just how bad this baseline is. We came to a similar conclusion in our [EMNLP paper](http://aclweb.org/anthology/D/D17/D17-1268.pdf), but with Google Translate. There's a tacit assumption in cross-lingual and multilingual NLP that if translation is available, it is the way to go. This may not always be true. 

(By the way, this is too strong of a baseline. They are targeting a low-resource scenario (i.e. no translation), so they just need to show that they beat the best available option.)

The final results (39F1 for Spanish, 23F1 for Chinese) aren't exactly impressive, but they do beat the baseline. Again, since there is no comparison with prior techniques or standard datasets, it's hard to know how good these are. 

