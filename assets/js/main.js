 function autoResizeDiv()
        {
            document.getElementById('map').style.height = window.innerHeight +'px';
        }
        window.onresize = autoResizeDiv;
autoResizeDiv();