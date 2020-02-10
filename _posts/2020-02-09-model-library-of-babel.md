---
layout: post
title: The Machine Learning Model Library of Babel
excerpt: In this library, all possible machine learning models exist.
comments: true
---

<img src="/assets/library-of-babel.jpg">

I recently read [The Library of Babel](https://maskofreason.files.wordpress.com/2011/02/the-library-of-babel-by-jorge-luis-borges.pdf) by Jorge Luis Borges, at the recommendation of a friend. It's a remarkable short story that plays with the concept of the space of all knowledge. You should go and read the original, but here's a short summary: this library consists of hexagonal rooms. "There are five shelves for each of the hexagon's walls; each shelf contains thirty-five books of uniform format; each book is of four hundred and ten pages; each page, of forty lines, each line, of some eighty letters." The letters, we later learn, come from a set of 25 symbols: "the space, the period, the comma, the twenty-two letters of the alphabet." 

This definition yields a finite number of books, all of which are contained in this library. (You can browse a digital version of the Library of Babel on [this website](https://libraryofbabel.info/).) The implications are profound: the book that describes the origin of the universe is in this library; the book that explains your personal history up to today is in this library; this blog post is in that library. In short, for any question you could think to ask, the answer is in the library. Of course, the cost is that the _finding the right book_ is a virtually impossible task. 

This reminded me of machine learning, especially in the era of models with [billions of parameters](https://openai.com/blog/better-language-models/), and it made me wonder about a machine learning model Library of Babel. Here's the thought experiment: assume that we fix the model to be the sequence to sequence Transformer, as in [Google's T5 model](https://colinraffel.com/publications/arxiv2019exploring.pdf), with a vocabulary of size of 32,000, using byte-pair encoding learned from all languages of Wikipedia (just going for something large and multilingual). I won't outline all the hyperparameters, but assume they are all fixed also. The architecture is fixed, the rest is just numbers. Numbers are infinite, but let's discretize the space to allow all numbers between -100 and 100 in increments of 0.0001.

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">How are there still mathematicians, we&#39;ve already discovered all the numbers dude what are you doing</p>&mdash; Raging Dull (@InternetHippo) <a href="https://twitter.com/InternetHippo/status/1210963009574711297?ref_src=twsrc%5Etfw">December 28, 2019</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 

Now, the architecture is fixed, there is a discrete set of options for each parameter, so this library is finite. Of course, the problem is the same as with the books: search in this space is *hard*. This is where optimization methods come in, but that's not the point. In this thought experiment, I want to ask, *what does this library contain?* Here are some options:
* Human level machine translation models for all pairs of languages (modulo vocabulary issues)
* A question answering system that gets human parity on SQuAD 2.0
* A system that can take a paragraph-long idea and generate a paper with a real contribution.

Ultimately, this question asks what we believe to be the limits of our current architectures. Do we believe that our current models/architectures are sufficient for the end goal, and the real question is one of data and search? Or will we need new architectures?

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">if i were a neural network i would simply find the right weights.</p>&mdash; Stephen Mayhew (@mayhewsw) <a href="https://twitter.com/mayhewsw/status/1200437281313738752?ref_src=twsrc%5Etfw">November 29, 2019</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 





