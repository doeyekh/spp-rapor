$(document).ready(function(){
    $(document).on('submit','.formLogin',function(e){
        e.preventDefault();
        $.ajax({
            url : '/login',
            dataType : 'json',
            method : 'post',
            data : $(this).serialize(),
            success:function(data){
                console.log(data);
                if(data.error){
                    if(data.error.email){
                        $('#email').addClass('is-invalid');
                        $('.errorEmail').html(data.error.email);
                    }else{
                        $('#email').removeClass('is-invalid');
                        $('.errorEmail').html('');
                    }
                    if(data.error.password){
                        $('#password').addClass('is-invalid');
                        $('.errorPassword').html(data.error.password);
                    }else{
                        $('#password').removeClass('is-invalid');
                        $('.errorPassword').html('');
                    }
                }
                if(data.salahemail){
                    $('#email').addClass('is-invalid');
                    $('.errorEmail').html(data.salahemail);
                }else{
                    $('#email').removeClass('is-invalid');
                    $('.errorEmail').html('');
                }
                if(data.salahpassword){
                    $('#password').addClass('is-invalid');
                    $('.errorPassword').html(data.salahpassword);
                }else{
                    $('#password').removeClass('is-invalid');
                    $('.errorPassword').html('');
                }
                if(data.sukses){
                    $('.alert').removeClass('d-none');
                    window.location = './home'
                }

            }

        })
    })
})