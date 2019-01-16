---
layout: post
title: Sequence-to-sequence for Text Cleaning
excerpt: asJdl;USTkjawp  ANOTHas;jERpojlwkej BLOtoGi lPOwkjeehSTohlbi
---

Following on from the trend in NLP of using sequence-to-sequence models
for <a href="https://arxiv.org/ftp/arxiv/papers/1604/1604.01537.pdf">just</a>
<a href="https://arxiv.org/pdf/1512.00103.pdf">about</a> <a href="https://pytorch.org/tutorials/intermediate/seq2seq_translation_tutorial.html">everything</a>, I was curious if one could use deep learning to
clean textual data. That is, we could translate "noisy" text into "clean"
text. For example, who among us hasn't written a regular expression
to remove html tags after scraping some web page? Or what about copying and pasting
from a PDF and all the page numbers and footers come with the text also?

So, as a fun little experiment, I tried doing this.

## Model
I used a sequence-to-sequence model with attention implemented with Allennlp and Pytorch. For the encoder, I used a bidirectional LSTM with hidden size of 20, an input size of 25, one layer, and dropout of 0.5. Since this was meant to be a quick holiday project, I didn't experiment with different parameters. Maybe in a future iteration!

The decoder doesn't do anything fancy, just greedily decodes symbols until a max length (based on the input size) or the end symbol is reached.

## Data
I took a set of pre-tokenized sentences and added my own noise (described below). The pre-tokenized set was the Brown
corpus (available through NLTK), which has about 55K sentences. This is not the largest
or most representative corpus, but it was easily available. I split the data into train/dev/test, of about
45K/5K/5K sentences each. 

Each sentence is represented as a sequence of characters, where the task is to select only those characters that
are non-noise. 

## Noise methods

I tried two different methods of adding noise. The first method was a random number of random strings (of random lengths)
inserted into a random character positions in a given sentence. An example is below:

```
``Failure to do thisgU1"M will continue to plalNce a disproportionate burden '' on FultonjB|&t|Q4 taxpayers.
```

The second method was similar, except the random string could not contain left or right arrows, which were instead
used as markers for start and end of noise, respectively, as in HTML. We generated new random noise for this experiment. For example:

```
``Failure to do this<7@c> will con<t*U#>tinue to place a disproportionate burde<i39sv&>n '' on Fulton taxpayers.
```

I would expect that the first method will be hard to recover from, but the second will be much easier. In principle, the network
should learn that the arrows enclose junk, making the task much easier to solve.

(One subtlety was that I never used the @ symbol in the noise, and instead used this to mark word boundaries. This allowed
me to use off-the-shelf seq2seq data readers that expect words instead of characters).


## Evaluation
Since this is a data cleaning operation, I measured performance with edit distance on the character level aggregated
over every sentence. A perfect model will produce an aggregate edit distance of 0. This is unlikely, so we also measure
the edit distance of each noisy input sentence against the gold, and use this as a baseline. 

An alternate way of doing this is sequence tagging: each character gets a binary label, denoting whether or not it should appear in the final clean version. With such a scheme, we could evaluate with F1. But this experiment is intended to play with seq2seq, so I won't go there.

# Results
The results are shown in the following tables.

| Random noise | Edit dist |
| -------------- | ----------- |
| Source | 51,093 |
| Predicted | 72,428 |


|  HTML noise | Edit dist |
| --- | --- |
| Source | 69,032 |
| Predicted | 46,575 |

In words, the first table says that the noisy source data deviated from the clean data with an aggregate edit distance of about 51K. With about 5K test sentences, this is roughly an average edit distance of 10 for each sentence. Compare with the Predicted value: 72K.
Since this has become significantly higher, we see that the cleaning process has not only failed, but made the data worse. The result is actually noisier than when we started. Now the average edit distance per sentence is closer to 14. We will see what this looks like in some examples below.

The story is different for the HTML noise, though. The source has an aggregate edit distance of 69K (avg about 14), and the predicted edit dist drops to 46K (avg about 9).
This is good: the noise cleaning model seems to have picked up on the pattern. 

# Examples
As promised, here are some examples of success and failure. First, for the random noise.

## Random noise Examples

| Gold  | Source | Edit dist |  Predicted | Edit Dist |
| -- | --| --| --| --|
| Dear Sirs : Let me begin by clearing up any possible misconception in your minds , wherever you are .|  Dear Sirs : Let me begin by clearing up any possible misconception in youPePLC[VWr minds , wherever you are . | 8 | Dear Sirs : Let me begin by clearing up any possible misconception in your minds , wherever you are . | 0 |
| Sort of remorseless , isn't it ? ? | FmWTyH<q`LSort of J<cCeB9$remo=jHrseless , isn't it ? ? | 21 | Sort of Jemerseless , isn't it ? ? | 2 |
| Still , there it is . | Still , there iJ2e$srF^q]%oMDGt is . | 15 | Still , there is . | 3 |
| Hold on tight . | Holb$z*Zx_dBS=d onZr=Sa:HNJ tight . | 20 | Hold on tight . | 0 |
| The foregoing , aided by several clues I'll withhold to keep you on your toes , will pursue you with a tenacity worthy of Inspector Javert , but before they close in , gird yourselves , I repeat , for a vengeance infinitely more pitiless . | The foregoing , aided by several clues I'll withhold to keep you on your toes , will pursue you with a tenacity worthy of Inspector Javert , but before they close in , gird yourselves , I repeat , for a vengeance infinitely more pitiless . | 0 | The foregoing , aided by several clues I'll whold to keep you our pursue you with a vengeance infinitely more pitiless . | 119 |
| You then descended one story , glommed a television set from the music room -- the only constructive feature of your visit , by the way -- and , returning to the ground floor , entered the master bedroom . | You the`x~'-n descended one story , glommed a television set from the music room -- the only constructive featuG)ks"}zYre of your visit , by the way -- and , returning to the ground floor , entered the master bedroom . | 13 |  You then descended one story , glommed a television set from the master bedroom . | 124|

The first four examples are successes: the predicted edit distance is lower than the source edit distance, even if there are some artifacts still.
The last two examples show how it can go wrong, in this case, by dropping large sections of (clean) text.
It's interesting that the resultant sentences are actually fairly fluent.
"Pursue you with a vengeance infinitely more pitiless" is not the correct text, but it's believable.
Same for the "glommed a television set from the master bedroom".

Ultimately, this seems to work well at removing noise (none of the examples retain the random character strings) but the ultimate sentences are not correct. Perhaps initializing the decoder with a pre-trained language model would help here.

## HTML noise Examples

| Gold  | Source | Edit dist |  Predicted | Edit Dist |
| -- | --| --| --| --|
| \`\` I was wrong '' , I admitted . | \`\` I was wrong '' , I admit<mf><i+Dng.U><kZN&ci>ted . | 21 | \`\` I was wrong '' , I admitted . | 0 |
| \`\` Comedy didn't die , it just went crazy . | <T]d>\`\` Comedy didn't die , it ju<Gt8,(x~>st went crazy . | 14 | \`\` Comedy didn't die , it just went crazy . | 0 |
| Why , it's all right , isn't it , Mother '' ? ? | Why , it'<L)\|%F+!>s all ri<f:>ght , isn't it , Mot<co.TZ>her '' ? ? | 20 | Why , it's all right , isn't it , Mother '' ? ? | 0 |
| \`\` What are my chances for taking Joe's place '' ? ? | \`\` Wha<a}hw>t are my chances for taking Joe's place '' ? ? | 6 | \`\` What are my chances for take '' ? ? | 14 |
| it is manic as a man '' . | it is manic as a man '' . | 0 | it is manic as a man '' is manic as a man ? gn is manic as a man ? . | 43 |

Again, the first three examples show cases where this works perfectly. It seems to have learned the rule for junk start and end symbols. When it fails (last two examples), it is either removing too much ("chances for take") or is entering the classic RNN generation loop ("manic as a man is manic as a man"). Again, perhaps this could be improved by pre-training the decoder with a language model.

# So?
This was a quick and dirty experiment, but we can draw some small conclusions from it. My intuition was confirmed: adding the junk markers improved performance significantly. It appears that junk can be detected and removed, but the decoding needs some help. It may be helpful to enforce that the decoder should never add characters to the original, only remove.
Then again, the best way for this is probably as a sequence-tagging task.

Perhaps a more interesting task would be to clean up OCR errors with a seq2seq model (in situations where the original images are no longer available). 