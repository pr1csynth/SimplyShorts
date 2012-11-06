/*
## FILE : parser.js
This javascript file setup blocks on each page to miminize space between blocks.
*/

var margin = 0;
var blocksToSuppr = "";
var blocks;
var header;

var debug = null;

function parseBlocks(){

    margin = header.offsetTop;
    padding = 10;
    
    var index = [0,0,0];
    
    index[0] = index[1] = index[2] = (2 * margin + header.offsetHeight);
    
    
    cc = 0;
    skip = false;

    for(id in blocks){
        block = blocks[id];

        if(typeof(block.className) != 'undefined'){
            
            if(block.className.indexOf('u1') != -1 ){
                block.style.top = (index[cc] - block.offsetTop + margin) + "px";
                index[cc] = block.offsetTop + block.offsetHeight + margin;
                cc ++;
            }else if(block.className.indexOf('u2') != -1 ){
              if(cc == 2){
                  cc = 0;    
              }
              
              block.style.top = (Math.max(index[cc],index[cc + 1]) - block.offsetTop + margin) + "px";
              index[cc] = index[cc + 1] = block.offsetTop + block.offsetHeight + margin;
              cc += 2; 
          }else if(block.className.indexOf('u3') != -1 ){
              block.style.top = (Math.max(index[0],index[1],index[2]) - block.offsetTop + margin) + "px";
              index[0] = index[1] = index[2] = block.offsetTop + block.offsetHeight + margin;
              cc = 0; 
          }
      }
      
      cc %= 3;
  }
}

function init(){
    
    blocks = document.getElementsByTagName('ARTICLE');
    header = document.getElementById('header');
    setTimeout(parseBlocks, 100);
}


