---
layout: post
title: How to use illinois-ner with Maven
excerpt: Here are some crazy tips UIUC researchers are freaking out about!
mathjax: true
---

Say you want to use [illinois-ner](https://github.com/IllinoisCogComp/illinois-cogcomp-nlp/tree/master/ner), maybe because it is [state-of-the-art](http://www.cs.brandeis.edu/~marc/misc/proceedings/naacl-hlt-2009/CoNLL/pdf/CoNLL19.pdf), maybe because it is _so easy to use_, maybe because
 there's an active development community on [github](https://github.com/IllinoisCogComp/illinois-cogcomp-nlp/issues), maybe because you've tried everything else, or maybe because you
 just have some free time.

 Good choice. You have good taste. This is a little tutorial to help you along. I'm going to pretend you know nothing, and start from scratch. By the end of this tutorial,
 you will be tagging text like nobody's business.

 I'm going to assume that you have started with a Ubuntu machine, and you have some Java, maven, and command-line skills. Let's
 download some prerequisites:

~~~bash
$ sudo apt-get install default-jre default-jdk
$ sudo apt-get install maven
~~~

 Ok, good. Now, let's create a bog-standard maven project as a container. You could read the [quick-start guide](https://maven.apache.org/guides/getting-started/),
 or you could just run this handy code snippet that I stole from that page.

~~~bash
 $ mvn -B archetype:generate \
     -DarchetypeGroupId=org.apache.maven.archetypes \
     -DgroupId=com.mycompany.app \
     -DartifactId=my-app
~~~

 This created a little skeleton of a maven project in a folder called `my-app/`. Now, following the directions on
 [this page](https://github.com/IllinoisCogComp/illinois-cogcomp-nlp#using-each-library-programmatically), add the
 correct dependency and repository to your `pom.xml`. It should now look like this:

~~~xml
 <project xmlns="http://maven.apache.org/POM/4.0.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
   xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/maven-v4_0_0.xsd">
   <modelVersion>4.0.0</modelVersion>
   <groupId>com.mycompany.app</groupId>
   <artifactId>my-app</artifactId>
   <packaging>jar</packaging>
   <version>1.0-SNAPSHOT</version>
   <name>my-app</name>
   <url>http://maven.apache.org</url>
   <dependencies>
     <dependency>
       <groupId>junit</groupId>
       <artifactId>junit</artifactId>
       <version>3.8.1</version>
       <scope>test</scope>
     </dependency>

     <!-- You added this -->
     <dependency>
       <groupId>edu.illinois.cs.cogcomp</groupId>
       <artifactId>illinois-ner</artifactId>
       <version>3.0.72</version>
     </dependency>

   </dependencies>

   <!-- And this -->
   <repositories>
     <repository>
       <id>CogcompSoftware</id>
       <name>CogcompSoftware</name>
       <url>http://cogcomp.cs.illinois.edu/m2repo/</url>
     </repository>
   </repositories>

 </project>
~~~

Well done. Make sure you are in the `my-app/` directory, and try compiling to see what
happens (there should be a lot of downloading, and then BUILD SUCCESS), and then run it.

~~~ bash
$ mvn compile
$ mvn exec:java -Dexec.mainClass=com.mycompany.app.App
~~~

This should print `"Hello World!"`.

Good, let's move on. Open up `src/main/java/com/mycompany/app/App.java`, and perform the right combination
of keystrokes and mouse movements until you get the following:

~~~ java
package com.mycompany.app;

import edu.illinois.cs.cogcomp.core.datastructures.textannotation.TextAnnotation;
import edu.illinois.cs.cogcomp.core.utilities.configuration.ResourceManager;
import edu.illinois.cs.cogcomp.nlp.utility.TokenizerTextAnnotationBuilder;
import edu.illinois.cs.cogcomp.annotation.TextAnnotationBuilder;
import edu.illinois.cs.cogcomp.core.datastructures.ViewNames;
import edu.illinois.cs.cogcomp.ner.NERAnnotator;
import edu.illinois.cs.cogcomp.nlp.tokenizer.IllinoisTokenizer;
import edu.illinois.cs.cogcomp.ner.LbjTagger.*;
import java.io.IOException;

import java.util.Properties;

/**
 * Hello world!
 *
 */
public class App
{
    public static void main( String[] args ) throws IOException
    {
        String text1 = "Good afternoon, gentlemen. I am a HAL-9000 "
            + "computer. I was born in Urbana, Il. in 1992";

        String corpus = "2001_ODYSSEY";
        String textId = "001";

        // Create a TextAnnotation using the LBJ sentence splitter
        // and tokenizers.
        TextAnnotationBuilder tab;
        tab = new TokenizerTextAnnotationBuilder(new IllinoisTokenizer());

        TextAnnotation ta = tab.createTextAnnotation(corpus, textId, text1);

        NERAnnotator co = new NERAnnotator(ViewNames.NER_CONLL);
        co.doInitialize();

        co.addView(ta);

        System.out.println(ta.getView(ViewNames.NER_CONLL));
    }
}
~~~

Now compile and run.

~~~bash
$ mvn compile
$ mvn exec:java -Dexec.mainClass=com.mycompany.app.App
~~~

This prints the entities that it has found, and which are accessible as Constituents in the TextAnnotation. To learn more
about TextAnnotations, Constituents, Views, and all the other data structures in the IllinoisCogComp ecosystem, see [here](https://github.com/IllinoisCogComp/illinois-cogcomp-nlp/tree/master/core-utilities).
