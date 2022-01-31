---
layout: post
title: (WIP) CoNLL NER Embeddings
excerpt: What happens if you visualize the embeddings of every CoNLL tag?
comments: false
---

<a href="/assets/conll-tags/ALL-by-label.html" target="_blank"><img src="/assets/conll-tags/ALL-by-label.png" /></a>

(Click on each image for an exploratory visualization, along with notes)

I was thinking about NER tagsets recently -- which tags should be included, what distinctions matter, where there is overlap -- and it occurred to me that a visualization of the embeddings of each entity phrase could help shed some light.

As with every other researcher for the past 19 years, the term "NER" makes me reflexively reach for [CoNLL-2003](https://www.clips.uantwerpen.be/conll2003/ner/) English dataset, with tagset: Person, Organization, Location, and Miscellaneous. Using the training set, I got the BERT embeddings (specifically [`distilroberta-base`](https://huggingface.co/distilroberta-base)) for each labeled span (summing constituent subwords), and projected to 2 dimensions with [T-SNE](https://scikit-learn.org/stable/modules/generated/sklearn.manifold.TSNE.html). I repeated this process 6 times: one for each of the 4 labels, then 2 different plots with all labels but distinct coloring. 

In one of the ALL plots, I colored according to tag (above). In all others (below), I categorized using properties of each entity: if it consisted of all capitals (`all_caps`), if it was the first token in a sentence (`initial`), if it was preceded by a left parenthesis (`paren`), and a catch-all category (`plain`). For the Location plot, I subdivided `plain` into `LOC` (if it was preceded by a preposition like "in" or "near") and `GPE` (all others).

I want to acknowledge that this project makes some assumptions:
- BERT embeddings encode something meaningful about language
- T-SNE projection is faithful to the underlying representations

"All models are wrong, but some are useful. -- George Box" -- Stephen Mayhew

Code can be found in [this notebook](https://github.com/mayhewsw/mayhewsw.github.io/blob/master/assets/conll-tags/cluster_conll.ipynb) (tip: open it in Colab and run it on GPU).

<a href="/assets/conll-tags/ALL.html" target="_blank"><img src="/assets/conll-tags/ALL.png" /></a>
<a href="/assets/conll-tags/PER.html" target="_blank"><img src="/assets/conll-tags/PER.png" /></a>
<a href="/assets/conll-tags/ORG.html" target="_blank"><img src="/assets/conll-tags/ORG.png" /></a>
<a href="/assets/conll-tags/LOC.html" target="_blank"><img src="/assets/conll-tags/LOC.png" /></a>
<a href="/assets/conll-tags/MISC.html" target="_blank"><img src="/assets/conll-tags/MISC.png" /></a>
