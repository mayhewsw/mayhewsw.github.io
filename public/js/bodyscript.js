/**
 * Created by stephen on 9/13/17.
 */
// THIS IS IMPORTANT!

// Nodes should have already been defined in myjs.js

// If you want links, they are here.
    var links = []; //[{source: nodes[1], target: nodes[0]}];

    var ws = d3.select("body").style("width");
    var w = ws.substring(0, ws.length - 2); // remove the px
    var h = 700;

    var color = d3.scale.category20();

    var force = d3.layout.force()
        .nodes(d3.values(nodes))
        .links(links)
        .size([w, h])
        .charge(-5400)
        .linkDistance(500)
        .linkStrength(0.6)
        .friction(0.7)
        .gravity(0.3)
        .on("tick", tick)
        .start();

    var svg = d3.select("body").append("svg:svg")
        .attr("width", w)
        .attr("height", h);

    var path = svg.append("svg:g").selectAll("path")
        .data(force.links())
        .enter().append("line")
        .attr("class", "link");

    var circle = svg.append("svg:g").selectAll("circle")
        .data(force.nodes())
        .enter().append("a")
        .attr("xlink:href", function (d) {
            return d.link + ""
        })

        // Doesn't work...
        //.attr("data-toggle", "popover")
        //.attr("data-content", "And here's some amazing content. It's very engaging. right?")
        .append("svg:circle")
        .attr("r", 50)
        .attr("id", function (d) {
            return getFname(d.link) + ""
        })
        .style("fill", function (d) {
            return color(d.group);
        })
        .on("mouseover", fade)
        .on("mouseout", leave)
        .call(force.drag);


    function getFname(s) {
        return s.replace(/\.[^/.]+$/, "");
    }


    function fade(d) {
        $("#" + getFname(d.link)).animate({
            opacity: 0.45,
        }, 200, function () {
            // Animation complete.
        });
        $("svg").animate({
            //backgroundImage: "url('http://www.helpinghomelesscats.com/images/cat1.jpg')",
            //width: 200,
        }, 200, function () {
        });

    }

    function leave(d) {
        $("#" + getFname(d.link)).animate({
            opacity: 1
        }, 300, function () {
            // Animation complete.
        });

    }


    function showPage(d) {

        d3.select(".centercontent").remove();
        d3.select(".centertext").remove();

        var bwidth = 200;
        var bheight = 200;

        var x = $("svg").width() / 2 - bwidth / 2;
        var y = $("svg").height() / 2 - bheight / 2;

        d3.select("svg").append("rect")
            .attr("x", x)
            .attr("y", y)
            .attr("width", bwidth)
            .attr("height", bwidth)
            .attr("class", "centercontent");


        text = svg.append("svg:text")
            .attr("x", x + 10)
            .attr("y", y + 19)
            .text(d3.html("test.html", function (t) {
                console.log(t.toString());
                return t.toString()
            }))
            .attr("class", "centertext");

    }


    $("svg").on("click", clearPage);

    function clearPage(d) {
        console.log(d.target.nodeName);
        if (d.target.nodeName != "circle") {
            console.log("let's not clear...");

            d3.select(".centercontent").remove();
            d3.select(".centertext").remove();

        } else {
            console.log("clearing page");
        }

    }


    var text = svg.append("svg:g").selectAll("g")
        .data(force.nodes())
        .enter().append("svg:g");

// A copy of the text with a thick white stroke for legibility.
    text.append("svg:text")
        .attr("x", -10)
        .attr("y", ".31em")
        .attr("class", "shadow")
        .text(function (d) {
            return d.name;
        });

    text.append("svg:text")
        .attr("x", -10)
        .attr("y", ".31em")
        .text(function (d) {
            return d.name;
        });

    function tick() {
        path.attr("x1", function (d) {
            return d.source.x;
        })
            .attr("y1", function (d) {
                return d.source.y;
            })
            .attr("x2", function (d) {
                return d.target.x;
            })
            .attr("y2", function (d) {
                return d.target.y;
            });

        circle.attr("transform", function (d) {
            return "translate(" + d.x + "," + d.y + ")";
        });

        text.attr("transform", function (d) {
            return "translate(" + d.x + "," + d.y + ")";
        });
    }

