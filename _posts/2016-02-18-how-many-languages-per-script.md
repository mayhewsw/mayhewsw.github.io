---
layout: post
mathjax: true
comments: true
excerpt: How many languages per script?
---

This afternoon, I found myself asking the following questions:

* how many scripts are there in the world?
* how many scripts are used by more than one language?
* what is the distribution of languages by script?

It turns out that these questions are answerable, but it is not trivial. Wikipedia has a [List of Languages by Writing System](https://en.wikipedia.org/wiki/List_of_languages_by_writing_system), but it is a little informal, and is hard to parse automatically. Besides, it seems incomplete. 

Omniglot has a [useful page](http://www.omniglot.com/writing/langalph.htm) on this, but it also feels incomplete and is not easy to parse.   

 So, I turned to [scriptsource.org](http://scriptsource.org/), a website affiliated with [SIL](http://www.sil.org/) that gives a lot of information and resources for the world's scripts. 

First, of the world's roughly 7000 languages, there are about 3500 that use a writing system of some kind ([source](https://www.ethnologue.com/enterprise-faq/how-many-languages-world-are-unwritten)). 

Then, according to [scriptsource](http://scriptsource.org/cms/scripts/page.php?item_id=script_overview), there are between 140 and 250 scripts, depending on whether you count historical and fictional scripts. Each of these is encoded in the [ISO15924](http://unicode.org/iso15924/iso15924-codes.html) standard as a 4 letter code. This suggests that there are an average of 25 languages per script. This is obviously wrong (the distribution is definitely not uniform), but let's keep looking. 

Each script has it's own page (for example, here's [Mongolian](http://scriptsource.org/cms/scripts/page.php?item_id=script_detail&key=Mong)) which includes a list of languages that use the script (for Mongolian, there are 11). I wrote a [simple scraper](https://gist.github.com/mayhewsw/1600aeade3693db38195) to get this number for each language.

(Note: some languages do not have this number in the page. Most notably, Latin script, the most popular. According to [omniglot](http://www.omniglot.com/writing/langalph.htm#latin), 513 languages use Latin script. Just to calibrate, they also say that Cyrillic has 112 languages, which checks out against scriptsource's 116)

To show the results, I plotted them with individual scripts on the x-axis and number of corresponding languages on the y-axis. 

<img style="width: 80%; display: block; margin: 0 auto", src="/assets/languages_by_script.png">









 

