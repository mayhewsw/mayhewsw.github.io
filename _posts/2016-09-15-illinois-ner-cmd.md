---
layout: post
title: How to use illinois-ner from the command line
excerpt: If you can't do it from the command line, it ain't worth doing.
mathjax: true
---

In the [previous blog post](), I outlined how to use illinois-ner as a dependency in a Maven project. In this
 post, I will address a slightly more hands-off crowd: you want to tag data, but you don't want to write code, and you
 _definitely_ don't want to install Maven. Fair enough.

 We will start from the illinois-ner download package, called something like `illinois-ner-X.X.XX.zip`. Unpack it and
 cd into it.

 ~~~bash
 $ unzip illinois-ner-X.X.XX.zip
 $ cd illinois-ner
 ~~~

 Spend a little time reading the README.md