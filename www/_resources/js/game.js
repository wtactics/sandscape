var globals = new function() {
//TODO: move globals here
}

//Global control variables
//TODO: //NOTE: shouldn't this be placed in a global object for easier control 
//and maintenance
var lastChange = 0;
var lastReceived = 0;
var gameRunning = false;
var bUrl;
var chkGameID;
var updGameID;
var updMessagesID;
var clientTime = new Date();
var stopPositionUpdate = false;

function initTable(base, messageUpUrl) {
   bUrl = base
    
   $('#opponent-loader').show();
   pack();
   $('#card-info-image').dblclick(function(e){
      alert('Not implemented yet!');
   });
    
   checkGameStart();
   updMessagesID = setInterval(function() {
      updateMessages(messageUpUrl)
   }, 5000);
}

function checkGameStart() {
   $.ajax({
      url: bUrl,
      data: {
         event: 'startGame'
      },
      type: 'POST',
      dataType: 'json',
      success: function (json) {
         if(json.result == 'ok') {
            $('#opponent-loader').remove();
            $('#game-loader').show();
            $.ajax({
               url: bUrl,
               data: {
                  event: 'startUp'
               },
               type: 'POST',
               dataType: 'json',
               success: function (json) {                       
                  if(json.result == 'ok') {
                     var create = json.createThis;
                     
                     // tokens
                     var tokenMenu = new Array();
                     $(json.gameInfo.tokens).each(function (i,o) {
                        tokenMenu.push({
                           option : o.name,
                           event: function (card) {
                              toggleCardToken($(card).attr('id'), o.id)
                           }
                        })
                     })
                     
                     // card states
                     var statesMenu = new Array();
                     $(json.gameInfo.cardStates).each(function (i,o) {
                        statesMenu.push({
                           option: o.name,
                           event: function (state) {
                              toggleCardState($(state).attr('id'), o.id)
                           }
                        })
                     })
                            
                     //set void object
                     $(document.createElement('div')).attr({
                        id: create.nowhere.id
                     })
                     .css({
                        visibility: 'hidden',
                        position: 'absolute',
                        top: -200,
                        left: -200
                     })
                     .appendTo($('body'));
    
                     //Player area: left hand, decks and play zone
                     $('.hand')
                     .attr('id', create.player.hand.id)
                            
                     $('.play')
                     .attr('id', create.player.playableArea.id)

                     for(i = 0; i < create.player.decks.length; i++) {
                        $(document.createElement('img'))
                        .attr({
                           id: create.player.decks[i].id, 
                           src: '_cards/up/thumbs/cardback.jpg'
                        })
                        .data('deck-name', create.player.decks[i].name)
                        .click(function() {
                           drawCard($(this).attr('id'));
                        })
                        .appendTo($('#deck-slide'));
                     }
                            
                     if(create.player.graveyard) {
                        $(document.createElement('img'))
                        .attr({
                           id: create.player.graveyard.id,
                           src: '_cards/up/thumbs/noimage.jpg'
                        })
                        .data('deck-name', 'Graveyard')
                        .appendTo($('#deck-slide'));
                     }
                            
                     //Configure deck widgets
                     //Define positions for existing decks
                     $('#deck-slide').children('img').each(function(index) {
                        $(this).css({
                           left: index * 85, 
                           top: 0,
                           position: 'absolute'
                        });
                     })
                            
                     //Opponent area (top window zone)
                     $('.opponent-area').attr('id', create.opponent.playableArea.id)
                     
                     var card;
                     for(i = 0; i < create.cards.length; i++) {
                        card = create.cards[i];
                                
                        $(document.createElement('div'))
                        .html('<img class="face" />')
                        .attr({
                           id: card.id
                        })
                        .addClass('card')
                        .draggable({
                           stack: '.card',
                           revert: 'invalid'
                        })
                        .appendTo($('body'));
                     }
                     
                     // Cards must be positioned after all cards are in the DOM because there are cards 'inside' other cards
                     for(i = 0; i < create.cards.length; i++) {
                        card = create.cards[i];
                        var location = $('#'+card.location);
                        
                        $('#'+card.id).css({
                           position: 'absolute',
                           visibility: card.visibility
                        })
                        .css({
                           top:  -200, //location.offset().top + card.yOffset * location.height(),
                           left: -200 // location.offset().left + card.xOffset * location.width()
                        })
                        .data('status', card)
                        .addClass('update')
                        .radialmenu({
                           radius: 60,
                           options: [ {
                              option: 'info',
                              event: function (card) {
                                 requestCardInfo($(card).attr('id'));
                              }
                           }, {
                              option: 'tokens',
                              subMenu: tokenMenu
                           }, {
                              option: 'card states',
                              subMenu: statesMenu
                           } ]
                        })
                        .children('img.face').attr('src', '_cards/up/thumbs/' + card.src);
                        
                        updateCardExtras($('#'+card.id));
                     }
                     
                     $('.card').droppable({
                        drop: function (event, ui) {
                           moveCard(ui.draggable.attr('id'), $(this).attr('id'), 0, .2);
                           return false;
                        }
                     })
                     
                     $('.play, .hand').droppable({
                        drop: function(event, ui) {
                           var card = ui.draggable;
                           
                           var xOffset = (card.offset().left - $(this).offset().left) / $(this).width();
                           var yOffset = (card.offset().top - $(this).offset().top) / $(this).height();
                           
                           moveCard(card.attr('id'), $(this).attr('id'), xOffset, yOffset);
                           return false;
                        }
                     })
                                                        
                     //Configure and set deck-nob widget
                     $(document.createElement('img')).attr({
                        id: 'deck-nob',
                        src: '_cards/up/thumbs/cardback.jpg'
                     })
                     .css('z-index', 100)
                     .click(deckSlide)
                     .appendTo($('body'));

                     gameRunning = true;
                     $('#game-loader').fadeOut('slow', function () {
                        $('#game-loader').remove();
                     }); 
                     
                     setTimeout(updateGame, 3000);
                     cyclicPositionUpdate();
                  }
               }
            });
         }
         else setTimeout(checkGameStart, 3000);
      },
      error: function () {
         setTimeout(checkGameStart, 3000);
      }
   });
}

function updateCardExtras(card) {
   if (card.data('status')){
      card.find('.token').remove();
      for (var i = 0; i < card.data('status').tokens.length; ++i) {
         $(document.createElement('img'))
         .addClass('token')
         .attr('src', '_tokens/up/thumbs/' + card.data('status').tokens[i].src)
         .appendTo(card);
      }
      
      card.find('.state').remove();
      for(var i=0; i<card.data('status').states.length; ++i) {
         $(document.createElement('img'))
         .addClass('state')
         .attr('src', '_states/' + card.data('status').states[i].src)
         .appendTo(card);
      }
   }
}

function cyclicPositionUpdate() {
   if (!stopPositionUpdate){
      $('.update').each(function (i, o) {
         o = $(o);
      
         if (o.data('status')  &&  !o.hasClass('ui-draggable-dragging')  &&  !o.is(':animated')  &&  o.data('status').visibility == 'visible')
         {
            var data = o.data('status');
            var location = $('#'+data.location);
            var top = location.offset().top + Math.round(data.yOffset * location.height());
            var left = location.offset().left + Math.round(data.xOffset * location.width());
            
            if (o.offset().top != top  ||  o.offset().left != left) 
            {
               o.animate({
                  top: top+'px',
                  left: left+'px'
               }, 500)
               
               if ($('.ui-draggable-dragging').length == 0) {
                  o.css({
                     zIndex: o.data('status').zIndex
                  });
               }
            }
         }         
      });
   }  
   setTimeout(cyclicPositionUpdate, 300);
}

function doGameUpdate(json) {
   if(json.result == 'ok'  &&  parseInt(json.clientTime) == clientTime.getTime()) {
      if (json.lastChange) lastChange = json.lastChange;
 
      for(i = 0; i < json.update.length; i++) {
         $('#' + json.update[i].id).data('status', json.update[i]);
         if(!$('#' + json.update[i].id).hasClass('update')) $('#' + json.update[i].id).addClass('movable');
         
         
         $('#' + json.update[i].id)
         .css({
            zIndex: json.update[i].zIndex,
            visibility: json.update[i].visibility
         })
         .children('img.face').attr('src',  '_cards/up/thumbs/' + json.update[i].src);
         
         updateCardExtras($('#' + json.update[i].id));
      }
   }
}


function updateGame() {
   clientTime = new Date();
   if (parseInt($.active) == 0  &&  $('.ui-draggable-dragging').length == 0){
      $.ajax({
         url: bUrl,
         data: {
            event: 'update',
            lastChange: lastChange,           // TODO: Solve the sync problems; This will still disabled until then
            clientTime: clientTime.getTime()
         },
         dataType: 'json',
         type: 'POST',
         success: doGameUpdate,
         complete: function () { 
            setTimeout(updateGame, 3000);
         }
      });
   }
   else setTimeout(updateGame, 3000);
}


function toggleCardToken(cardId, tokenId){
   clientTime = new Date();
   if ($('.ui-draggable-dragging').length == 0) {
      $.ajax({
         url: bUrl,
         data: {
            event: 'toggleCardToken',
            card: cardId,
            token: tokenId,
            clientTime: clientTime.getTime()
         },
         dataType: 'json',
         type: 'POST',
         success: doGameUpdate
      })
   }
}

function toggleCardState(cardId, stateId) {
   clientTime = new Date();
   if ($('.ui-draggable-dragging').length == 0) {
      $.ajax({
         url: bUrl,
         data: {
            event: 'toggleCardState',
            card: cardId, 
            state: stateId,
            clientTime: clientTime.getTime()
         },
         dataType: 'json',
         type: 'POST',
         success: doGameUpdate
      })
   }
}

function drawCard(deckId) {
   stopPositionUpdate = true;
   clientTime = new Date();
   $.ajax({
      url: bUrl,
      data: {
         event: 'drawCard',
         deck: deckId,
         clientTime: clientTime.getTime()
      },
      dataType: 'json',
      type: 'POST',
      success: doGameUpdate,
      complete: function () {
         stopPositionUpdate = false;
      }
   });
}

function moveCard(cardId, destinationId, xOffset, yOffset) {
   stopPositionUpdate = true;
   clientTime = new Date();
   $.ajax({
      url: bUrl,
      data: {
         event: 'moveCard',
         card: cardId,
         location: destinationId,
         xOffset: xOffset,
         yOffset: yOffset,
         clientTime: clientTime.getTime()
      },
      dataType: 'json',
      type: 'POST',
      success: doGameUpdate,
      complete: function () {
         stopPositionUpdate = false;
      }
   });
}

function requestCardInfo(id) {
   $.ajax({
      url: bUrl,
      data: {
         event: 'cardInfo',
         card: id
      },
      type: 'POST',
      dataType: 'json',
      success: function (json) {
         if(json.success) {
            $('#card-info-name').html(json.name);
            $('#card-info-image').attr('src', '_cards/up/thumbs/' + json.image);
            $('#card-info-states').html(json.states);
            $('#card-info-rules').html(json.rules);
         }
      }
   })
}

function pack() {   
   $('#info-widget').css({
      width: 350,
      height: $(window).height() / 2,
      top: 0,
      left: 0,
      position: 'absolute'
   });
   $('.opponent-area').css({
      width: $(window).width() - 350,
      height: $(window).height() / 2,
      top: 0,
      left: 350,
      position: 'absolute'
   });
    
   $('.hand').css({
      width: 350,
      height: $(window).height() / 2,
      top: $(window).height() / 2,
      left: 0,
      position: 'absolute'
   });  
    
   $('.play').css({
      width: $(window).width() - 350,
      height: $(window).height() / 2,
      top: $(window).height() / 2,
      left: 350,
      position: 'absolute'
   });
}

function bubbles() {   
   $('#deck-slide img').CreateBubblePopup({
      position: 'top',
      align: 'center',
      tail: {
         align: 'center'
      },

      themeName: 'all-black',
      themePath: '_resources/images/jqBubblePopup',
      alwaysVisible: false,
      closingDelay: 100
   });
    
   var text;
   $('#deck-slide img').each(function(index) {
      text = $(this).data('deck-name');
        
      if(text.length == 0) {
         text = 'Unknown Deck';
      }
      $(this).SetBubblePopupInnerHtml(text);
   })
}

function deckSlide (event) {
   if(gameRunning) {
      if($('#deck-widget').width() > 0) {
         $('#deck-slide img').each(function() {
            if( $(this).HasBubblePopup() ){
               $(this).RemoveBubblePopup();
            }
         });    
       
         $('#deck-widget').animate({
            width: 0
         });
      } else {
         $('#deck-widget').animate({
            width: $('#deck-slide').children('img').length * 85
         }, function() {
            bubbles();
         });
      }
   }
}
function showChat() {
   if($('#chat').position().top == 0) {
      $('#chat').animate({
         top: -255
      });
   } else {
      $('#chat').animate({
         top: 0
      });
   }
}

function sendMessage(destination) {
   var message = $("#writemessage").val();
   if(message.length > 0) {
      $.ajax({
         type: "POST",
         url: destination,
         data: {
            'gamemessage': message
         },
         dataType: 'json',
         success: function(json) {
            if(json.success) {
               $('#chat-messages').append('<li class="user-message"><span><strong>' + json.name + '</strong>&nbsp;[' 
                  + json.date + ']:</span>' + message + '</li>');
                    
               lastReceived = json.id;
               updateMessageScroll();
            }
         }
      });
      $("#writemessage").val('');
   }
}

function updateMessages(destination) {
   $.ajax({
      type: "POST",
      url: destination,
      data: {
         'lastupdate': lastReceived
      },
      dataType: 'json',
      success: function(json) {
         if(json.has) {
            $.each(json.messages, function() {
               $('#chat-messages').append('<li class="user-message"><span><strong>' + this.name + '</strong>&nbsp;[' 
                  + this.date + ']:</span>' + this.message + '</li>');
            });

            lastReceived = json.last;
            updateMessageScroll();
         }
      }
   });
}

function updateMessageScroll() {
   $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
}

function filterChatMessages(elem) {
   if(elem.id == 'fshow-all') {
      $('li.user-message').show();
      $('li.user-system').show();
   } else if(elem.id == 'fshow-user') {
      $('li.user-message').show();
      $('li.user-system').hide();
   } else if(elem.id == 'fshow-system') {
      $('li.user-message').hide();
      $('li.user-system').show();
   }    
}

function lost() {
   alert('Not implemented yet!');
}