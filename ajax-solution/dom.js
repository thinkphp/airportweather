        /* Utilities */

        var DOMhelp = {

            addEvent: function(elem,evType,fn,useCapture) {

                      if(elem.addEventListener) {

                        return elem.addEventListener(evType,fn,useCapture);

                      } else if(elem.attachEvent) {

                         var r = elem.attachEvent('on'+evType,fn);

                         return r;

                      } else {

                        elem['on'+evType] = fn;
                      }
            },

            $: function(id){return document.getElementById(id);}  
        };
