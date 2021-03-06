window.addEventListener("load",function()
{
    var boton = document.getElementById("btn");
    var chatino = document.getElementById("chat-window");
    var formularino = document.getElementsByTagName("form")[0];
    var ultimoMensaje = 0;

    boton.onclick = enviarMensaje;
    
    var tempoMsg = setInterval(pideUltimosMensajes,5000);

    async function enviarMensaje(ev) // Lo suyo es la función limpia señor --> Creo que tengo que cambiarlo por FormData.
    {
        ev.preventDefault();
        if(formularino["user"].value != "" && formularino["msg"].value != "")
        {
            let imagen = "";
            if(formularino["archivo"].files.length > 0)
            {
                imagen = formularino["archivo"].files[0];
            }

            var formData = new FormData();
            formData.append("user",formularino["user"].value);
            formData.append("msg",formularino["msg"].value);
            formData.append("archivo",imagen);

            fetch("inserta.php",{
                method:"POST",
                body:formData
            }).then(response => response.text())
            .catch(error=>console.error("Error",error))
            .then(response => {
                formularino["msg"].value="";
                formularino["msg"].focus();
                formularino["archivo"].value="";
            })
        }

    }

    function pideUltimosMensajes() // Falta por meterle un abort de esos // Y que se pueda ver los mensajes del usuario y tal // Y que se quede el scroll en su sitio
    {
        const chatero = new XMLHttpRequest();
        chatero.onreadystatechange = function()
        {
            let nomerico = ultimoMensaje;
            if(chatero.readyState==4 && chatero.status==200)
            {
                var obJotason = JSON.parse(this.responseText);
                if(obJotason.mensajes.length>0)
                {
                    for(let i = 0; i < obJotason.mensajes.length; i++)
                    {
                        var div = crearMensaje(obJotason.mensajes[i], formularino["user"].value);
                        chatino.appendChild(div);
                    }
                    ultimoMensaje = obJotason.ultimo;
                }
            }
                // Cambiar por aquí lo que hay que cambiar me cachis en la mar.
                // Si el scroll no está en los últimos 300 píxeles, no le hacemos caso. "Si me salgo de la pantalla".
                // Ah bueno con antes de mandar se refiere al send. Claro, tiene sentido
                if(chatino.scrollTop > (chatino.scrollHeight - 650))
                {
                    chatino.scrollTop = chatino.scrollHeight;
                    document.getElementById("mensajes-nuevos").innerHTML = "";
                }
                else
                {
                    if(nomerico != ultimoMensaje)
                    {
                        document.getElementById("mensajes-nuevos").innerHTML = "Hay mensajes nuevos";
                    }
                }

                mensajes = chatino.children;
                for (let i = 0; i < mensajes.length; i++)
                {
                    if(formularino["user"].value == mensajes[i].children[0].innerHTML)
                    {
                        mensajes[i].className = "propio";
                    }
                    else
                    {
                        mensajes[i].className = "ajeno";
                    }
                }
        }
        
        chatero.open("GET","pide.php?ultimo="+ultimoMensaje);
        chatero.send();
        
    }

    function crearMensaje(mensaje, autor)
    {
        var div = document.createElement("div");
        var claseUsuario = (mensaje.user == autor)?"propio":"ajeno";
        var usuario = document.createElement("div");
        usuario.innerHTML = mensaje.user;
        usuario.className = "div-usuario";
        var fecha = document.createElement("div");
        fecha.innerHTML = mensaje.fecha;
        fecha.className = "div-fecha";
        var imagen = document.createElement("div");
        if((/^\/9j\//).test(mensaje.imgblob))
        {
            imagen.innerHTML = "<img src='data:image/jpg;base64,"+mensaje.imgblob+"'/>"
        }
        imagen.className = "div-texto";
        var texto = document.createElement("div");
        texto.innerHTML = mensaje.msg;
        texto.className = "div-texto";
        div.className = claseUsuario;
        div.appendChild(usuario);
        div.appendChild(fecha);
        div.appendChild(imagen);
        div.appendChild(texto);

        return div;
    }

})