const app = (() => {

    const handlers = (() => {

        return {
            addState: document.getElementById('add-state'),
            editState: document.getElementById('edit-state'), 
            removeState: document.getElementById('remove-state'),
            addTileForm: document.getElementById('add-tile-form'),
            editTileForm: document.getElementById('edit-tile-form'),
            removeTileForm: document.getElementById('remove-tile-form')
        }
    })();

    const listeners = handlers => {

        handlers.addState.addEventListener('click', () => {

            handlers.addTileForm.classList.remove('is-hidden');
            handlers.editTileForm.classList.add('is-hidden');
            handlers.removeTileForm.classList.add('is-hidden');
        });

        handlers.editState.addEventListener('click', () => {

            handlers.editTileForm.classList.remove('is-hidden');
            handlers.addTileForm.classList.add('is-hidden');
            handlers.removeTileForm.classList.add('is-hidden');
        });

        handlers.removeState.addEventListener('click', () => {

            handlers.removeTileForm.classList.remove('is-hidden');
            handlers.editTileForm.classList.add('is-hidden');
            handlers.addTileForm.classList.add('is-hidden');
            
        });

        handlers.editTileForm.addEventListener('dblclick', e => {

            const node = e.target.parentNode;

            if(node.classList.value === 'edit-tiles') {
                
                const idParts = node.id.split('-');
                const id = parseInt(idParts[idParts.length - 1]);

                window.location.href = `edit?id=${id}`;
            }
        });

        handlers.removeTileForm.addEventListener('dblclick', e => {

            const node = e.target.parentNode;

            if(node.classList.value === 'remove-tiles') {
                
                const idParts = node.id.split('-');
                const id = parseInt(idParts[idParts.length - 1]);

                if(confirm(`Do you want to remove this tile? [${id}]`)) {

                    window.location.href = `remove?id=${id}`;
                } 
                
            }
        });
    };

    
    return {
        init: () => {
            listeners(handlers);
        }
    }
})();

app.init();