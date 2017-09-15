
console.log("Using myjs.js. Yes.");

// define the nodes
var nodes = [
             {name: "About Me", link:"aboutme.php", group:"1"},
             {name: "Research", link:"research.php", group:"7"},
             {name: "Links", link:"links.php", group:"3"},
             {name: "Non-existent Page", link:"nonexistent.php", group:"4"},
             {name: "Projects", link:"projects.php", group:"5"}
             ];

//var color = d3.scale.category20(); 

// A $( document ).ready() block.
$( document ).ready(function() {
        var hp = "http://cogcomp.cs.illinois.edu/~mayhew2/";
        
        // Update the nav bar
        for (i in nodes){
            //console.log(nodes[i]);
            var n = nodes[i]; 
            $("#pagesbar").append("<li><a href='" + hp + n.link +  "'>"+ n.name + "</a></li>");
        };

        $(".headface").mouseover(function(d) {
                console.log("on");
                $(".circular").animate({opacity: 0.45}, 200, function(){});
            });
        
        $(".headface").mouseout(function(d) {
                console.log("off");
                $(".circular").animate({opacity: 1}, 200, function(){});
            });

        // for (i in nodes){
        //     var n = nodes[i];
        //     $("#" + getFname(n.link)).mouseover(function(d) {
        //             $("#" + getFname(n.link)).animate({fill: "black"}, 200, function(){});
        //         });

        // };


    $('div.pub').mouseenter(function () {
        $(this).css("border-left", "0 solid #DDD").animate({
            borderWidth: 4,
            paddingLeft: 10
        }, 50);
    }).mouseleave(function () {
        $(this).animate({
            borderWidth: 0,
            paddingLeft: 0
        }, 100);
    });
    
    });





