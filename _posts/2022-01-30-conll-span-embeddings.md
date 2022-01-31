---
layout: post
title: CoNLL NER Embeddings
excerpt: What happens if you visualize the embeddings of every CoNLL tag?
comments: false
---


I was thinking about NER tagsets recently -- which tags should be included, what distinctions matter, where there is overlap -- and it occurred to me that a visualization of the embeddings of each entity phrase could help shed some light (not unlike [Datamaps](https://arxiv.org/pdf/2009.10795.pdf)).

You can click on each image for an ✨ interactive visualization ✨, or read farther for details and observations.

<a href="/assets/conll-tags/ALL-by-label.html" target="_blank"><img src="/assets/conll-tags/ALL-by-label.png" width="40%"  style="display:inline"/></a>
<a href="/assets/conll-tags/ALL.html" target="_blank"><img src="/assets/conll-tags/ALL.png" width="40%" style="display:inline" /></a>
<a href="/assets/conll-tags/PER.html" target="_blank"><img src="/assets/conll-tags/PER.png" width="40%"   style="display:inline"/></a>
<a href="/assets/conll-tags/ORG.html" target="_blank"><img src="/assets/conll-tags/ORG.png" width="40%"   style="display:inline"/></a>
<a href="/assets/conll-tags/LOC.html" target="_blank"><img src="/assets/conll-tags/LOC.png" width="40%"   style="display:inline"/></a>
<a href="/assets/conll-tags/MISC.html" target="_blank"><img src="/assets/conll-tags/MISC.png" width="40%"   style="display:inline"/></a>


## Embedding Entities
As with every other researcher for the past 19 years, the term "NER" makes me reflexively reach for [CoNLL-2003](https://www.clips.uantwerpen.be/conll2003/ner/) English dataset, with tagset: Person, Organization, Location, and Miscellaneous. Using the training set, I got the BERT embeddings (specifically [`distilroberta-base`](https://huggingface.co/distilroberta-base)) for each labeled span (summing constituent subwords), and projected to 2 dimensions with [T-SNE](https://scikit-learn.org/stable/modules/generated/sklearn.manifold.TSNE.html). I repeated this process 6 times: one for each of the 4 labels, then 2 different plots with all labels but distinct coloring. 

In one of the ALL plots, I colored according to tag (above). In all others (below), I categorized using properties of each entity, assigning the first applicable category in this order: if it was preceded by a left parenthesis (`paren`), if it consisted of all capitals (`all_caps`), if it was the first token in a sentence (`initial`),, and a catch-all category (`plain`). For the Location plot, I subdivided `plain` into `LOC` (if it was preceded by a preposition like "in" or "near") and `GPE` (all others).

## Observations

In the ALL-by-label plot, different areas for each label are apparent. Interestingly, Person is the most distinct. Although Organization and Location have central areas of density, the boundaries are less clear. Miscellaneous, on the other hand, seems to exist in the same spaces as Organization and Location. This will be explored more in a later section. 

<a href="/assets/conll-tags/ALL.html" target="_blank"><img src="/assets/conll-tags/ALL-odd-island.png"  class="image-right" /></a>
There's an odd island with center around (-4, -4). This becomes clearer when we look at the plot with the alternate coloring: that entire island is green, indicating that those entities are all capitalized. Unsurprisingly, each individual label plot shows a similar pattern. 

Why are these all grouped together? It could be that BERT relies heavily on orthography, but it could also be an anomaly of the dataset, in which certain types of sentences are capitalized. Most points in this cluster represent document metadata strings, identifying location and date ("CALGARY 1996-08-23", "BOMBAY 1996-08-22") and some are document titles ("LOMBARDI WINS THIRD STAGE..."). 

There's a separate green cluster near point (1, -7) which includes many strings like "U.S.". Interestingly, this cluster has small satellite clusters containing strings like "U.N." (United Nations) and "S.C." (South Carolina), suggesting that the cluster is based on orthography. But there is also a satellite cluster for "United States", suggesting that entity reference is also sometimes used. 

<a href="/assets/conll-tags/ALL.html" target="_blank"><img src="/assets/conll-tags/ALL-us.png"/></a>


## Assumptions

I want to acknowledge that this project makes some assumptions:
- BERT embeddings encode something meaningful about language
- T-SNE projection is faithful to the underlying representations

"All models are wrong, but some are useful. -- George Box" -- Stephen Mayhew

Code can be found in [this notebook](https://github.com/mayhewsw/mayhewsw.github.io/blob/master/assets/conll-tags/cluster_conll.ipynb) (tip: open it in Colab and run it on GPU).


