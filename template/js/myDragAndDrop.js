window.onload = function(){
    var dragSrcEl = null;

    function handleDragStart(e){
        // Target (this) element is the source node.
        this.style.opacity = '0.4';
        dragSrcEl = this;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragOver(e){
        if(e.preventDefault){
            e.preventDefault(); // Necessary. Allows us to drop.
        }
        e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

        this.classList.add('over');
        return false;
    }

    function handleDragEnter(e){
        // this / e.target is the current hover target.
        this.classList.add('over');
    }

    function handleDragLeave(e){
        this.classList.remove('over');  // this / e.target is previous target element.
    }

    function handleDrop(e){
        // this/e.target is current target element.
        if(e.stopPropagation){
            e.stopPropagation(); // Stops some browsers from redirecting.
        }
        // Don't do anything if dropping the same column we're dragging.
        if(dragSrcEl !== this){
            // Set the source column's HTML to the HTML of the column we dropped on.
            //dragSrcEl.innerHTML = this.innerHTML;
            //this.innerHTML = e.dataTransfer.getData('text/html');
            this.appendChild(dragSrcEl);
            if(this.className.startsWith('lb ')){
                
                var list = this;
                var items = list.childNodes;
                var itemsArr = [];
                for(var i in items){
                    if(items[i].nodeType == 1){ // get rid of the whitespace text nodes
                        itemsArr.push(items[i]);
                    }
                }

                itemsArr.sort(function(a, b){
                    var na = a.querySelectorAll('[name=nombre]')[0].innerHTML;
                    var nb = b.querySelectorAll('[name=nombre]')[0].innerHTML;
                    return na === nb
                            ? 0
                            : (na > nb ? 1 : -1);
                });

                for(i = 0; i < itemsArr.length; ++i){
                    list.appendChild(itemsArr[i]);
                }
            }
        }
        return false;
    }

    function handleDragEnd(e){
        // this/e.target is the source node.
        [].forEach.call(elems, function(elem){
            elem.classList.remove('over');
        });
        this.style.opacity = '1';
    }

    var elems = document.querySelectorAll('.elemento');
    [].forEach.call(elems, function(elem){
        elem.addEventListener('dragstart', handleDragStart, false);
        //elem.addEventListener('dragenter', handleDragEnter, false);
        elem.addEventListener('dragover', handleDragOver, false);
        elem.addEventListener('dragleave', handleDragLeave, false);
        //elem.addEventListener('drop', handleDrop, false);
        elem.addEventListener('dragend', handleDragEnd, false);
    });
    var elems = document.querySelectorAll('.elementob');
    [].forEach.call(elems, function(elem){
        elem.addEventListener('dragstart', handleDragStart, false);
        //elem.addEventListener('dragenter', handleDragEnter, false);
        //elem.addEventListener('dragover', handleDragOver, false);
        //elem.addEventListener('dragleave', handleDragLeave, false);
        //elem.addEventListener('drop', handleDrop, false);
        elem.addEventListener('dragend', handleDragEnd, false);
    });
    var elems = document.querySelectorAll('.la, .lb');
    [].forEach.call(elems, function(elem){
        elem.addEventListener('dragenter', handleDragEnter, false);
        elem.addEventListener('dragover', handleDragOver, false);
        elem.addEventListener('dragleave', handleDragLeave, false);
        elem.addEventListener('dragend', handleDragEnd, false);
        elem.addEventListener('drop', handleDrop, false);
    });


};
