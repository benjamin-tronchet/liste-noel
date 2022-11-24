function santa() {
    const santa = document.querySelector('[data-action=toggle-santa]');
    
    santa.addEventListener('click', function(event) {
        var parent = document.querySelector('.c-santa'),
            data;
        
        if(parent.classList.contains('close')) {
            data = "santa=expand";
        }
        else
        {
            data = "santa=close";
        }
        fetch('ajax/santa.php', {
            method:'post',
            headers: {
                'Content-Type':'application/x-www-form-urlencoded'
            },
            body: data
        })
        .then(() => parent.classList.toggle('close'));
    });
}

santa();

function input_file() {
    
    const input = document.querySelector('input[type=file]');
    
    if(input)
    {
        input.addEventListener('change',(event) => {
        
            var reader = new FileReader(),
                parent = input.closest('.c-form_field'),
                wrapper = parent.querySelector('.c-form_file_image'),
                old_file = parent.querySelector('input[type=hidden]'),
                output = wrapper.querySelector('img');

            if(old_file) {
                old_file.remove();
            }

            reader.onload = function(){
                output.setAttribute('src', reader.result);
                parent.classList.add('masked');
                setTimeout(function() {
                    wrapper.classList.remove('masked');
                    wrapper.classList.add('unmasked');
                }, 500);
            };
            reader.readAsDataURL(event.target.files[0]);
        });   
    }
}

input_file();

function dropdown() {
    const dropdown_buttons = document.querySelectorAll('.c-form_dropdown_btn');
    const dropdowns = document.querySelectorAll('.c-form_dropdown');
    const options = document.querySelectorAll('.c-form_dropdown_list li');
       
    const evenement = document.createEvent("HTMLEvents");
    evenement.initEvent("change", true, true);
    evenement.eventName = "change";
    
    // Ouverture du dropdown
    
    Array.from(dropdown_buttons).forEach(function(Object) {
        Object.addEventListener('click',function(event){
            event.preventDefault();
            this.closest('.c-form_dropdown').classList.toggle('active');
        })
    });
    
    // Sélection d'une option
    
    Array.from(options).forEach(function(Object) {
        Object.addEventListener('click',function(event){
            event.preventDefault();
            const value = this.dataset.value,
                  text  = this.textContent;
            
            this.closest('.c-form_dropdown').querySelector('input').value = value;
            this.closest('.c-form_dropdown').querySelector('input').dispatchEvent(evenement);
            this.closest('.c-form_dropdown').querySelector('.c-form_dropdown_btn .text').textContent = text;
            this.closest('.c-form_dropdown').classList.toggle('active');
            this.closest('.c-form_dropdown').querySelector('.c-form_dropdown_btn').classList.add('active');
        })
    });
    
    // Fermeture du dropdown au clic ailleurs sur la page
    
    document.addEventListener('click',function(event) {
        if(!event.target.closest(".c-form_dropdown")) {
            Array.from(dropdowns).forEach(function(Object){
                Object.classList.remove('active');  
            });
        }
    });
    

}

dropdown();

function change_value() {
    const inputs = document.querySelectorAll('[data-change-value]');
    
    // Ouverture du dropdown
    
    Array.from(inputs).forEach(function(Object) {
        Object.addEventListener('change',function(event){
            const target = this.getAttribute('data-change-value'),
                  value = this.value,
                  element = document.querySelector('[data-change='+target+']');
            
            element.setAttribute('href',element.getAttribute('href')+value+'/');
        });
    });
}

change_value();

function show_hidden() {
    const hidden_items = document.querySelectorAll('[data-hidden]');
    
    Array.from(hidden_items).forEach(function(Object) {
        Object.classList.add('active');
    });
}

function modal() {
            
    // Ouverture de la modale
    const modals = document.querySelectorAll('[data-modal]'),
          modal = document.querySelector('.u-modal');
    
    Array.from(modals).forEach(function(Object){
        Object.addEventListener('click',function(event){
            event.preventDefault();
            const target = Object.dataset['modal'],
                  data = Object.dataset['post'];
            open_modal(target,data);
        });
    });

    // Fermeture de la modale
    document.addEventListener('click',function(event){
        if(event.target.hasAttribute('data-close-modal'))
        {
            const active_modal = document.querySelector('.u-modal.active');
            if(active_modal)
            {
                close_modal(active_modal);
            }
        }
    });
    
    function open_modal(target,data) {
        const test = fetch('includes/modals/'+target+'.php', {
            method:'post',
            headers: {
                'Content-Type':'application/x-www-form-urlencoded'
            },
            body: data
        })
        .then(data => data.text())
        .then(function (text) {
            modal.innerHTML = text
        })
        .then(() => setTimeout(
            () => modal.classList.add('active'), 200
        ));
    }
    
    function close_modal(target) {
        const element = target.querySelector('.u-modal_box')
        modal.classList.remove('active');
        
        setTimeout(
            () => element.parentNode.removeChild(element),
            1000
        );
    }
}



// Fonction de fermeture et suppression de la modale
// Au passage : on réinclut dans le body le contenu de la modale pour pouvoir la réutiliser ultérieurement
function closeModal(modale) {

    if($('.u-modal').find('[data-modal-video]').length)
    {
        $('.u-modal').find('[data-modal-video]').get(0).pause();
    }

    $('.u-modal').removeClass('active');
    setTimeout(function(){
        modale.remove();
    },1100);

}

modal();

function panel() {
            
    // Ouverture du panel
    const panel_buttons = document.querySelectorAll('[data-panel]'),
          panel = document.querySelector('.u-panel');
    
    if(panel.classList.contains('active'))
    {
        document.querySelector('.u-panel_content').classList.add('active');
    }
    
    Array.from(panel_buttons).forEach(function(Object){
        Object.addEventListener('click',function(event){
            event.preventDefault();
            const target = Object.dataset['panel'],
                  data = Object.dataset['post'];
            open_panel(target,data);
        });
    });

    // Fermeture du panel
    document.addEventListener('click', function(event) {
        if(event.target.hasAttribute('data-close-panel'))
        {
            const active_panel = document.querySelector('.u-panel.active');
            if(active_panel)
            {
                close_panel(active_panel);
            }
        }
    });
    
    function open_panel(target,data) {
        const test = fetch('includes/modals/'+target+'.php', {
            method:'post',
            headers: {
                'Content-Type':'application/x-www-form-urlencoded'
            },
            body: data
        })
        .then(data => data.text())
        .then(function (text) {
            panel.innerHTML += text;
        })
        .then(() => setTimeout(
            function() {
                panel.classList.add('active');
                panel.querySelector('.u-panel_content').classList.add('active');
                input_file();
                form_checker();
            }, 50
        ));
    }
    
    function close_panel(target) {
        const element = target.querySelector('.u-panel_content');
        
        element.classList.remove('active');
        panel.classList.remove('active');
        
        setTimeout(
            () => {
                element.parentNode.removeChild(element);
                form_checker();
            },
            500
        );
    }
}

panel();

function notifications() {
    const notif = document.querySelector('[data-notif]');
    
    if(notif) {
        
        setTimeout(() => notif.classList.add('active'), 500);
        
        setTimeout(() => notif.classList.add('remove'), 5500);
        
        setTimeout(() => notif.parentNode.removeChild(notif), 6300);
    }
}

notifications();

function menu() {
    const buttons = document.querySelectorAll('[data-action=menu]');
    
    for(button of buttons)
    {
        button.addEventListener('click',(event) => {
            event.target.closest('nav').classList.toggle('active');
        });
    }
}

menu();