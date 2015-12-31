---
layout: post
mathjax: true
comments: true
excerpt: How to use illinois-transliteration
---

This code is in our group's private gitlab repository, but is available upon request. This post is meant as a quick place for a tutorial on the code.

First, look at `Runner.java`, and set the `trainlang` and `testlang` variables. These are languages for test and train. Typically, these should be the same. In the most common use case, these are names of languages as found in Wikipedia (and specifically, which correspond to files I have downloaded, and which are in the directory variable called `wikidata`). For example, `Hindi` and `Hindi`.

Next, set the `method` variable. In the most common use case, this is the string `"wikidata"`. Notice also that `NUMTRAIN` and `NUMTEST` variables should be set. These should add up to less than the size of the data file. For example, if the Hindi training file has 1000 pairs, you can have `NUMTEST` and `NUMTRAIN` at 600 and 400 respectively.

With method `wikidata`, this calls the `TrainAndTest` method, which trains and tests the model in a loop. This is to smooth out any randomness and get the average, because we shuffle the training data and results can vary.

If you want to create a model for use at another time, this happens with the `model.WriteProbs(...)` code. This will overwrite at each iteration, so you just need a single iteration (i.e. `num=1`). This model is a text file called `probs-*.txt` where the `*` represents the training language. It is a set of weighted productions from English to the target language. 

You can read this model file using the `SPModel(file)` constructor. For an example of this, see the `LoadAndTest` method in `Runner.java`. 

When you want to generate candidates in a trained language, look at the code in `TestGenerate` method. Essentially, you give it a string, and it returns a ranked list of candidates. If you only need one, just get the top element. 

To run, you can just use the `runner.sh` script in the `scripts/` directory.

```
> ./scripts/runner.sh
```






 

