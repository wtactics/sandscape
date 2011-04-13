$(document).ready(function() {
    $('#stats-slide p a').click(function(){
        var slide = $('#stats-slide');
        slide.animate({
            left: parseInt(slide.css('left'),10) == 0 ? -slide.outerWidth() + 25 : 0
        });
        if(slide.data('hidden')) {
            slide.data('hidden', false);
            $('#stats-slide p a').html('&lt;&lt;&nbsp;');
        } else {
            slide.data('hidden', true);
            $('#stats-slide p a').html('&gt;&gt;&nbsp;');
        }
    });
    
    startGameBoard();
});

function startGameBoard() {
    var elem = document.getElementById('drawarea');
    if (elem && elem.getContext) {
        
        var graphics2d = elem.getContext('2d');
        if (graphics2d) {
               
            //debugging code
            var pattern = [5, 5];
            var width = 1105;
            var height = 700;
            
            graphics2d.fillStyle = '#FFF';
            graphics2d.fillRect(0, 0, 1105, 700);
            
            graphics2d.strokeStyle = '#000';
            graphics2d.beginPath();
            graphics2d.dashedLineTo(0, height / 2, width, height / 2, pattern);
            graphics2d.dashedLineTo(width / 2, 0, width / 2, height, pattern);
            graphics2d.stroke();
            
            graphics2d.dashedSquare(2, 2, 161, 116, pattern);
            graphics2d.dashedSquare(2, 125, 161, 116, pattern);
            //
            graphics2d.dashedSquare(width - 165, height - 118, 161, 116, pattern);
            graphics2d.dashedSquare(width - 165, height - 240, 161, 116, pattern);
            //end
            
            
        } else {
            alert('Failed to initialize the 2D context.');
        }
    }
}

CanvasRenderingContext2D.prototype.dashedLineTo = function (fromX, fromY, toX, toY, pattern) {
    // Our growth rate for our line can be one of the following:
    //   (+,+), (+,-), (-,+), (-,-)
    // Because of this, our algorithm needs to understand if the x-coord and
    // y-coord should be getting smaller or larger and properly cap the values
    // based on (x,y).
    var lt = function (a, b) {
        return a <= b;
    };
    var gt = function (a, b) {
        return a >= b;
    };
    var capmin = function (a, b) {
        return Math.min(a, b);
    };
    var capmax = function (a, b) {
        return Math.max(a, b);
    };

    var checkX = {
        thereYet: gt, 
        cap: capmin
    };
    var checkY = {
        thereYet: gt, 
        cap: capmin
    };

    if (fromY - toY > 0) {
        checkY.thereYet = lt;
        checkY.cap = capmax;
    }
    if (fromX - toX > 0) {
        checkX.thereYet = lt;
        checkX.cap = capmax;
    }

    this.moveTo(fromX, fromY);
    var offsetX = fromX;
    var offsetY = fromY;
    var idx = 0, dash = true;
    while (!(checkX.thereYet(offsetX, toX) && checkY.thereYet(offsetY, toY))) {
        var ang = Math.atan2(toY - fromY, toX - fromX);
        var len = pattern[idx];

        offsetX = checkX.cap(toX, offsetX + (Math.cos(ang) * len));
        offsetY = checkY.cap(toY, offsetY + (Math.sin(ang) * len));

        if (dash) this.lineTo(offsetX, offsetY);
        else this.moveTo(offsetX, offsetY);

        idx = (idx + 1) % pattern.length;
        dash = !dash;
    }
};

CanvasRenderingContext2D.prototype.dashedSquare = function (x, y, width, heigh, pattern) {
    this.beginPath();
    this.dashedLineTo(x, y, x + width, y, pattern);
    this.dashedLineTo(x + width, y, x + width, y + heigh, pattern);
    this.dashedLineTo(x + width, y + heigh, x, y + heigh, pattern);
    this.dashedLineTo(x, y + heigh, x, y, pattern);
    this.stroke();
}

//yes, this is a ternary operator!...
Array.prototype.contains = Array.prototype.indexOf ?
    function(val) {
        return this.indexOf(val) > -1;
    } :
    function(val) {
        var i = this.length;
        while (i--) {
            if (this[i] === val) {
                return true;
            }
        }
        return false;
    };


//TODO: to remove
function debug(context) {
    var oldFill = context.fillStyle;
    var oldStroke = context.strokeStyle;
    
    
    context.fillStyle = '#000';
    context.fillRect(0, 0, 800, 640);
    //
    context.beginPath();
    context.strokeStyle = '#F00';
    context.moveTo(0, 320)
    context.lineTo(800, 320);
    context.stroke();
    context.strokeStyle = '#FFF';
    //
    context.fillStyle = oldFill;
    context.strokeStyle = oldStroke;
}
//END

//TESTING CARDS
//http://localhost/spikes/card-images/DonationsforRecovery.png
//http://localhost/spikes/card-images/DoubttheViolence.png
//http://localhost/spikes/card-images/ElvishArcher.png
//http://localhost/spikes/card-images/ElvishFighter.png
//http://localhost/spikes/card-images/ElvishRanger.png
//http://localhost/spikes/card-images/ElvishMarksman.png
//http://localhost/spikes/card-images/ElvishScout.png
//http://localhost/spikes/card-images/ElvishShaman.png
//http://localhost/spikes/card-images/ElvishSharpshooter.png
//http://localhost/spikes/card-images/ElvishShyde.png
//http://localhost/spikes/card-images/MermanBrawler.png
//http://localhost/spikes/card-images/MermanHoplite.png
////http://localhost/spikes/card-images/CardBack.png

//TODO: card object, own file?
function Card(name, description, url, position) {
    this.name = name;
    this.description = description;
    this.position = position;
    this.tokens = Array();
    
    this.image = new Image();
    this.image.src = url;

    this.toString = function() {
        return 'Card {name = ' + this.name + ', description = ' + this.description + ', image = ' + this.image.src + '}';
    };
    
    this.move = function (position) {
        
    }

    this.draw = function(graphics2d) {
    };
    
    
}

//TODO: deck object, own file?
function Deck(name, position) {
    
}
