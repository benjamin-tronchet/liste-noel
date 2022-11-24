async function form_checker() {
    
    // ***** Variables utiles 

    const formulaires = document.querySelectorAll('[is-checked]');
    let y;
    
    for(formulaire of formulaires) {
        
        let formState = true;

        // ***** Vérification des inputs / textarea

        let form_inputs = formulaire.querySelectorAll('input,textarea,select'), i;

        for(i = 0; i < form_inputs.length; ++i) {
            const element = form_inputs[i];
            let name = element.getAttribute('name');

                name = name.replaceAll("][","--");
                name = name.replaceAll("]","--");
                name = name.replaceAll("[","--");

            const element_name = name.split('--');

            form_inputs[i].element_name = element_name;
        } 
        
        form_inputs.forEach((index) => {
            index.addEventListener('change', async (event) => {
                formState = await check_form_fields(index,index.element_name,true);
            });
        });
        
        formulaire.addEventListener('submit', async (event) => {
            
            event.preventDefault();
            
            let is_error = false;
            
            for(index of form_inputs) {
                formState = await check_form_fields(index,index.element_name,true);
                
                if(!formState)
                {
                    is_error = true;
                }
            };
            
            if(!is_error) {
                if(formulaire.hasAttribute('is-ajax'))
                {
                    ajax_submit(formulaire);
                }
                else
                {
                    formulaire.submit();
                }
            }
            
        });
    }
};

form_checker();

async function check_form_fields(element,element_name,formState) {
    let required_state,
        format_state;
    
    if (element_name[0] !== undefined) {
        switch (element_name[0]) {
            case 'required':
                required_state = checkRequired(element);
                if (!required_state) {
                    formState = false;
                }
                break;
            case 'alpha':
            case 'alphanum':
            case 'url':
            case 'mail':
            case 'phone':
            case 'checkbox':
            case 'image_normal':
                format_state = checkFormat(element,element_name[0]);
                if (!format_state) {
                    formState = false;
                }
                break;
            default:
                break;
        }
    }

    if (element_name[1] !== undefined && formState) {
        switch (element_name[1]) {
            case 'alpha':
            case 'alphanum':
            case 'url':
            case 'mail':
            case 'phone':
            case 'checkbox':
            case 'image_normal':
                format_state = checkFormat(element,element_name[1]);
                if (!format_state) {
                    formState = false;
                }
                break;
            default:
                break;
        }
    }
    
    if(element.dataset.verification)
    {
        const parent = element.closest('.c-form_field'),
              route = element.dataset.verification;
        
        let value = element.value,
            data = new FormData();
        
        data.append('value',value);
        
        const result = await check_specific_field(data,route);
        
        if(result.error)
        {
            parent.classList.add('error');
            parent.setAttribute('data-message', result.message);
            formState = false;
        }
    }
    
    if(element.dataset.same)
    {
        const target = document.querySelector(element.dataset.same),
              parent = element.closest('.c-form_field');
        
        let value = element.value,
            value2 = target.value;
        
        if(value !== value2)
        {
            parent.classList.add('error');
            parent.setAttribute('data-message', 'Les deux mots de passe ne correspondent pas');
            formState = false;
        }
    }
    
    return formState;
}

async function check_specific_field(data,route) {
    const response = await fetch('ajax/'+route+'.php', {
        method:'post',
        body: data
    });
    
    const text = await response.text(),
          json = JSON.parse(text);
    
    return json;
}

// ***** Vérification des éléments requis

function checkRequired(element) {
    let value = element.value,
        message = element.getAttribute('data-required'),
        parent = element.closest('.c-form_field,.c-form_field--price');

    if (value == "" || value == undefined) {
        parent.classList.add('error');
        parent.setAttribute('data-message', message);
        return false;
    } else if (element.getAttribute('type') == "checkbox") {

        let element_name = element.getAttribute('name'),
            checkboxes = document.querySelectorAll('[name='+element_name+']'),
            is_checked = false,
            y;

        for(y = 0; y< checkboxes.length; ++y) {
            if(checkboxes[y].checked)
            {
                is_checked = true;
            }
        }
        if (!is_checked) {
            parent.classList.add('error');
            parent.setAttribute('data-message', message);
            return false;
        } else {
            parent.classList.remove('error');
            return true;
        }
    } else {
        parent.classList.remove('error');
        return true;
    }
}

// ***** Vérification du format des données
function checkFormat(element, format) {
    
    
    // ***** Variables utiles et patterns 
    
    const value = element.value,
        parent = element.closest('.c-form_field'),

        PATTERN_num = /^[0-9 ]*$/,
        PATTERN_TITLE_num = "Seul les chiffres et les espaces sont autorisés",

        PATTERN_alpha = /^[A-Za-z' èéàùçâêûôîäüöïë,-.]*$/,
        PATTERN_TITLE_alpha = "Seul les lettres et les espaces sont autorisés",

        PATTERN_alphanum = /^[A-Za-z0-9' èéàùçâêûôîäüöïë,-.\/()!?:\";*+]*$/,
        PATTERN_TITLE_alphanum = "Seul les lettres, les chiffres et les espaces sont autorisés",

        PATTERN_phone = /^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/,
        PATTERN_TITLE_phone = "Merci de renseigner un numéro de téléphone valide",

        PATTERN_email = /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$/,
        PATTERN_TITLE_email = "L\'email doit être écrit au format contact@exemple.com",

        PATTERN_url = /^http(s)?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=])*$/,
        PATTERN_TITLE_url = "L'url doit être au format http(s)://www.ton-url.com",

        PATTERN_TITLE_file = "L'extension du fichier n'est pas supportée.";
    
    // ***** Pas de valeur ? Le champ n'est pas requis, et n'a pas été renseigné : on skippe
    
    if (value == "" || value == undefined) {
        parent.classList.remove('error');
        return true;
    }
    
    // ***** Sinon, on vérifie le format des données attendues

    switch (format) {
        case 'alpha':
            if (!PATTERN_alpha.test(value)) {
                parent.classList.add('error');
                parent.setAttribute('data-message', PATTERN_TITLE_alpha);
                return false;
            } else {
                parent.classList.remove('error');
                return true;
            }
            break;
        case 'alphanum':
            if (!PATTERN_alphanum.test(value)) {
                parent.classList.add('error');
                parent.setAttribute('data-message', PATTERN_TITLE_alphanum);
                return false;
            } else {
                parent.classList.remove('error');
                return true;
            }
            break;
        case 'url':
            if (!PATTERN_url.test(value)) {
                parent.classList.add('error');
                parent.setAttribute('data-message', PATTERN_TITLE_url);
                return false;
            } else {
                parent.classList.remove('error');
                return true;
            }
            break;
        case 'mail':
            if (!PATTERN_email.test(value)) {
                parent.classList.add('error');
                parent.setAttribute('data-message', PATTERN_TITLE_email);
                return false;
            } else {
                parent.classList.remove('error');
                return true;
            }
            break;
        case 'phone':
            if (!PATTERN_phone.test(value)) {
                parent.classList.add('error');
                parent.setAttribute('data-message', PATTERN_TITLE_phone);
                return false;
            } else {
                parent.classList.remove('error');
                return true;
            }
            break;
        case 'image_normal':
            const test = element.getAttribute('name'),
                  extensions = element.getAttribute('accept').split(','),
                  split = value.split("."),
                  ext = "." + split[split.length - 1].toLowerCase();
            
            if (extensions.indexOf(ext) !== -1) {
                parent.classList.remove('error');
                return true;
            } else {
                parent.classList.add('error');
                parent.setAttribute('data-message', PATTERN_TITLE_file);
                return false;
            }
            break;
        default:
            return true;
    }
}

function close_modal() {
    document.addEventListener("click", seek_modal);
}

function seek_modal(event) {
    let element = event.target,
        modale = document.querySelector('.contact-form_overlay');
    
    if(element.closest('.contact-form_overlay') || element.classList.contains('contact-form_overlay'))
    {
        modale.classList.add('close');
        setTimeout(function(){
            modale.parentNode.removeChild(modale);
        },700);
    }
}

async function ajax_submit(form) {
    const route = form.getAttribute('action'),
          parent = form.closest('.u-panel_content'),
          response = await fetch(route, {
                method:'post',
                body: new FormData(formulaire)
            });
    
    const text = await response.text(),
          json = JSON.parse(text);
    
    if(json.message) 
    {
        form.classList.add('inactive');
        
        const message = document.createElement('div');
        message.classList.add('u-panel_message','inactive');
        message.innerHTML = '<b>'+json.message+'</b>';
        parent.append(message);
        
        setTimeout(function(){
            message.classList.remove('inactive');
        },400);
    }
}

close_modal();