function all_field_is_not_empty() {
    let income = $("#income_date").val()
    let outcome = $("#outcome_date").val()
    let humans = $("#human_count").val()
    if (income && outcome && humans && (income < outcome)) {
        $(".free_rooms").fadeIn(1000)
        
        if (income && outcome && humans) {
            $.ajax({

                type:"post",
                url:"server_action.php",
                data: 
                {  
                'income' :income,
                'outcome': outcome,
                'people': humans
                },
                cache:false,
                success: function (html)  {
                    $('#msg').html(html);
                }
            });
            return false;

        }
    }
}


function showModal(id) {
    // console.log(id)
    var btn = document.getElementById(id);
    var modal = document.getElementById("myModal-borko");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
        var picture_name = document.getElementById("here_picture")

        // remove all nested child picture!!!
        while (picture_name.firstChild) {
            picture_name.firstChild.remove()
        }

        // add some text in modal, replace with img later!
        var text = document.createTextNode(id);
        var pic = document.createElement('img');
        pic.src = `room_pictures/${id}.jpg`
        picture_name.appendChild(text)
        picture_name.appendChild(pic)
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}


function when_radio_is_clicked() {
    $(".person_info").fadeIn(1000)
}


$(document).ready(function () {
    $("#income_date").change(function() {
        all_field_is_not_empty()
    });

    $("#outcome_date").change(function() {
        all_field_is_not_empty()
    });

    $("#human_count").change(function() {
        all_field_is_not_empty()
    });
});


