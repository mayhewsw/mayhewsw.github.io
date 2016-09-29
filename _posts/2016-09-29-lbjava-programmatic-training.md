---
layout: post
title: How to programmatically train LBJava
excerpt: You CAN teach an old classifier new tricks.
mathjax: true
---

Perhaps you read [an old LBJava tutorial](http://cogcomp.cs.illinois.edu/page/tutorial.201310/) and saw how
simple and easy it is to build a classifier. You're on the second round of funding in your machine learning
startup, and you've begun to wonder if it's possible to train a classifier in Java code instead of during
the LBJava compile time. That would definitely convince the VCs. Turns out it's pretty simple. Here's how.

I'm going to assume you have already followed and understood [the prior tutorial](http://cogcomp.cs.illinois.edu/page/tutorial.201310/).
The first thing to do is to open the .lbj file and remove the training and testing clauses from the classifier. The feature
definitions remain the same.

Here's the old one:

~~~java
discrete SpamClassifier(Document d) <-
   learn Label
   using WordFeatures, BigramFeatures

   from new DocumentReader("data/spam/train")
   5 rounds
   with new NaiveBayes()

   testFrom new DocumentReader("data/spam/test")
end
~~~

Here's the new one (just 3 lines removed):

~~~java
discrete SpamClassifier(Document d) <-
   learn Label
   using WordFeatures, BigramFeatures
   with new NaiveBayes()
end
~~~

Notice what has been removed: the lines defining the training and testing data. Notice what has remained: the definition
of the classifier, and the specification of label and features.

Now, compile this code. I like to use Maven and the [lbjava-mvn-plugin](https://github.com/IllinoisCogComp/lbjava/tree/master/lbjava-mvn-plugin).

~~~bash
$ mvn lbjava:compile
$ mvn compile
~~~

Check in your source tree to see that `SpamClassifier.java` has been generated. There should also be feature files. Notice
that `SpamClassifier.lc` and `SpamClassifier.lex` have also been created. These are dummy model and lexicon files
 respectively. These can safely be ignored, but should not be deleted.


Great, now we just need to train and test in Java code. Keep in mind what ingredients we need: a classifier (this is `SpamClassifier.java`), and
 a Parser (this is `DocumentReader.java`). The LBJava package has a class called
 [BatchTrainer](http://cogcomp.cs.illinois.edu/software/doc/LBJava/apidocs/edu/illinois/cs/cogcomp/lbjava/learn/BatchTrainer.html)
 which we will use for training.


Let's see how to use it. Create a new file called, say, `Trainer.java`.

~~~java
import edu.illinois.cs.cogcomp.lbjava.classify.TestDiscrete;
import edu.illinois.cs.cogcomp.lbjava.learn.BatchTrainer;

public class Trainer {

    public static void Train(){
        // instantiate the untrained classifier
        SpamClassifier cls = new SpamClassifier();

        String path = "data/spam/train/";

        // create the BatchTrainer object
        DocumentReader dr = new DocumentReader(path);
        BatchTrainer bt = new BatchTrainer(cls, dr, 50000);

        // and train!
        int iterations = 10;
        bt.train(iterations);

        // save the model files to these locations (for convenience)
        cls.write("model", "lexicon");

    }

    public static void Test() {
        // instantiate the trained classifier
        SpamClassifier cls = new SpamClassifier("model", "lexicon");
        SpamLabel oracle = new SpamLabel();

        String path = "data/spam/test/";
        DocumentReader dr = new DocumentReader(path);
        TestDiscrete tt = TestDiscrete.testDiscrete(cls, oracle, dr);

        tt.printPerformance(System.out);
    }

    public static void main(String[] args) {
        Train();
        Test();
    }

}
~~~

There you go. That's it.