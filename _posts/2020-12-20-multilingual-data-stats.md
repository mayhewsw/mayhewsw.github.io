---
layout: post
title: Multilingual Data Stats
excerpt: TLDR Multilingual Wikipedia is about 80GB.
comments: true
---

I recently compiled [a github repo](https://github.com/mayhewsw/multilingual-data-stats/) with statistics on datasets used for training multilingual models, such as [mBERT](https://github.com/google-research/bert/blob/master/multilingual.md), [XLM](https://arxiv.org/pdf/1901.07291.pdf), [XLM-R](https://arxiv.org/pdf/1911.02116.pdf), and [mT5](https://arxiv.org/pdf/2010.11934.pdf). But even with all this data in one place, some comparisons are still hard to make.

In particular, the [XLM-R paper](https://arxiv.org/pdf/1911.02116.pdf) describes the training data size as 2.5TB. But what does this actually mean, and how does it compare to the Wikipedia data used to train mBERT and XLM?

Let's first see if we can get this 2.5TB number from other tables. Using [this file](https://github.com/mayhewsw/multilingual-data-stats/blob/main/cc-100/cc-100.csv), which is just Table 6 from Appendix A, we can sum up the "Size GB" column: 2.394TB. That's pretty close to 2.5TB, and what's 100GB between friends anyway.

Comparing these values against files from the [CC-100 website](http://data.statmt.org/cc-100/), as I did in the [README](https://github.com/mayhewsw/multilingual-data-stats/tree/main/cc-100), we see that these reported numbers are _uncompressed_ text, and probably calculated from raw untokenized text files.

Compare this against the table of [Wikipedia sizes](https://github.com/mayhewsw/multilingual-data-stats/blob/main/wiki/wiki.csv) from my multilingual data stats repo. If you sum up the "Uncompressed Wiki Size (bytes)" column of languages present in mBERT, you end up with about **80GB of text** (~12.6B tokens). Remember when that was a lot of text?

Not all datasets report the file size. To get a rule of thumb for uncompressed dataset size given the number of tokens and vice versa, we can calculate the average number of bytes per token. Since Unicode characters are between 1 and 4 bytes, this amounts loosely to the number of characters per token.  In the Wikipedia corpus, the median and mean values are 5.87 and 7.07 respectively. In the CC-100 corpus, the median and mean values are 7.9 and 145.8 (!!).

This high number has to point to some mistakes in the CC-100 table! For example, the reported values for Ukrainian (6.5 M tokens and 84.6GiB) mean that there are 13,015 bytes/token, which seems... high. Similar problems exist for Thai and Chinese (perhaps segmentation errors?) and Swedish.

**Update (12/23/20)**: I emailed the authors, and they confirmed the Ukrainian and Swedish numbers were typos in the paper. The Chinese, Thai, and Japanese numbers are calculated without segmentation.

In the Wikipedia datset, the top 3 languages with the largest numbers of bytes/word are Korean (18.7), Georgian (17.8), and Mingrelian (16.1). This probably says more about the unicode encoding than the average word length, although with some careful alphabet accounting, you could probably figure it out.
