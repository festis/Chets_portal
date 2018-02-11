</div> <!-- end container div -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo HTTP ?>/js/hideShowPassword.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP ?>/js/tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP ?>/js/app.js"></script>

<script>
    $(document).ready(function() {
        <?php if (isset($user)): ?>
            var userId = <?php echo $user->id; ?>;
            $('#formProfile').validate({
                rules: {
                    name: 'required',
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '/<?php echo \App\Config::SITE_NAME; ?>/account/validate-email',
                            data: {
                                ignore_id: function() {
                                    return userId;
                                }
                            }
                        }
                    },
                    password: {
                        minlength: 6,
                        validPassword: true
                    }
                },
                messages: {
                    email: {
                        remote: 'email already taken'
                    }
                }
            });
        <?php endif; ?>
        
        $('#formSignup').validate({
            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true,
                    remote: '/<?php echo \App\Config::SITE_NAME; ?>/account/validate-email'
                },
                password: {
                    required: true,
                    minlength: 6,
                    validPassword: true
                }
            },
            messages: {
                email: {
                    remote: 'email already taken'
                }
            }
        });
        
        $('#formPassword').validate({
            rules: {                
                password: {
                    required: true,
                    minlength: 6,
                    validPassword: true
                }
            }
        });
        
        /**
        * Show password toggle button
         */
        $('#inputPassword').hideShowPassword({
            show: false,
            innerToggle: 'focus'
        });
        
        /**
        * Table sorting plugin
         */
        $("table").tablesorter({
                sortList: [[1,0]] 
        });
        
        /**
        * Add a part row in the purchasing app
        */
        $("#add").click(function() {
            $('#mytable tbody>tr:last').clone(true).insertAfter('#mytable tbody>tr:last').hide().fadeIn(25).find("input:text").val("");
            return false;
        });
        
        /**
        * Delete a row in the purchasing app
         */
        $("#deleteButton").click(function(){
            $(this).closest("tr").remove();
        });
    });
</script>
</body>
</html>