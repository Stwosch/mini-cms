const app = (() => {

	let doAjax = true;

    const addTiles = html => {
        $('.container').append(html);
    };

    const ajax = (offset, rows) => {

        $.ajax({
            url: "get-tiles",
            method: "POST",
            data: { offset, rows }
        })
        .done(data => {

            if(data) {
                addTiles(data);
            } else {
            	doAjax = false;
            }
        })
        .fail(err => {
            console.log(err);
        });


        $('.loader').hide();
    };

    const scroll = rows => {

        let offset = 5;

        $(window).on('scroll', () => {

            if($(document).height() - $(window).height() ===  $(window).scrollTop()) {

                if(doAjax) {

                	$('.loader').show();

                	ajax(offset, rows);
               		offset += rows;
                }  
            }

        });

    };

    return {
        init: config => {
            
            scroll(config.rows);
        }
    }

})();

app.init({
    rows: 3
});