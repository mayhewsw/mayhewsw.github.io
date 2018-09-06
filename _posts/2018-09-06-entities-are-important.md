---
layout: post
title: Entities are Important
excerpt: Who cares about NER anyway?
---

When I explain to friends and acquaintances that my work is in Named Entity Recognition (NER), the next question is often: why is this important? This is a fair question, and one I ask myself a good deal. One answer I give is this: NLP is (ostensibly) all about understanding text, and entities are important for understanding text.

One way to see this is to try and understand a document with all entities removed. Below is an article from the BBC that has all entities replaced with their CoNLL types (PER, ORG, MISC, LOC). My guess is that this article is pretty useless, unless you are already familiar with this piece of news.

> LOC emerges from LOC bailout programme
>
> LOC has successfully completed a three-year LOC emergency loan programme worth €61.9bn (£55bn; $70.8bn) to tackle its debt crisis.
>
> It was part of the biggest bailout in global financial history, totalling some €289bn, which will take the country decades to repay.
>
> Deeply unpopular cuts to public spending, a condition of the bailout, are set to continue.
>
> But for the first time in eight years, LOC can borrow at market rates.
>
> The economy has grown slowly in recent years and is still 25% smaller than when the crisis began.
>
> "From today, LOC will be treated like any other LOC area country," the ORG's Commissioner on Economic and Financial Affairs, PER PER, said on Monday.
>
> Its reforms had, he said, "laid the foundation for a sustainable recovery" but he also cautioned that its recovery was "not an event, it is a process".
>
> According to the ORG ORG ORG (ORG), only four countries have shrunk economically more than LOC in the past decade: LOC, LOC, LOC, and LOC LOC.
>
> The last €61.9bn was provided by the ORG ORG ORG (ORG) in support of the MISC government's efforts to reform the economy and recapitalise banks.

Pretend for a moment that you haven't read this news before. A discerning reader will infer that this must be somewhere in Europe, because of the currency. Those who follow European politics and economics probably have a good idea (the numbers help, by the way, an argument for mathematical reasoning), and someone with an encyclopedic knowledge of the global economy could precisely say what the 5th most shrunk national economy is. But for the rest of us, it is just abstract statements about banks and bailouts.

And here are the missing entities (I tagged "eurozone" as LOC, which is somewhat suspect, but bear with me).

> Greece, eurozone, Greece, eurozone, Greece, Greece, Europe, EU, Pierre Moscovici, International Monetary Fund (IMF), Greece, Yemen, Libya, Venezuela, Equatorial Guinea, European Stability Mechanism (ESM). Greek

Now you know what the article was about. The entities themselves are instructive as to the topic (Greece and IMF in particular), but it's certainly not true that entities alone are sufficient to understand a document.

The picture I'm trying to paint is related to the [linguistic notion of reference](https://glossary.sil.org/term/reference). Not being a linguist, I will say as little as possible, but it is very hard to refer to concrete named entities without using their names. For example, one might try to communicate the idea of "Greece" by saying "the home country of the philosopher who self-administered poison, and after whom a teaching method is named" (because we are also not allowed to say "Socrates"). Good luck with the IMF.

Therefore, if you want to refer to concrete named entities (and most of us do, most of the time), then your utterances will include named entities. Grounding these utterances in some concrete reality is arguably an important step for understanding. So natural language understanding will require named entity recognition.

(If you have comments on this, feel free to [email me](http://mayhewsw.github.io/assets/resume.pdf))
