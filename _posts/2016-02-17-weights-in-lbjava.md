---
layout: post
mathjax: true
comments: true
excerpt: How to get weights in LBJava
---

If you're using LBJava, chances are you will eventually want to get
weights from a classifier (for inspection, usually). Here's a simple way to do it:

~~~ java
public static Map<String, Double> getFeatureWeights(Learner c) {
    ByteArrayOutputStream sout = new ByteArrayOutputStream();
    PrintStream out = new PrintStream(sout);
    c.write(out);
    String s = sout.toString();

    String[] lines = s.split("\n");
    Lexicon lexicon = c.getLexicon();

    Map<String, Double> feats = new HashMap<String, Double>();
    for (int i = 2; i < lines.length - 1; ++i) {
        String line = lines[i];
        String featid = lexicon.lookupKey(i - 2).toStringNoPackage(); // .getStringIdentifier();
        feats.put(featid, Double.parseDouble(line));
    }
    return feats;
}
~~~



 

