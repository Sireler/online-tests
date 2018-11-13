<template>
    <div class="container register-container">
        <div class="row">
            <div class="col-md-10 offset-md-1 register-form">
                <h3>Register</h3>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Email *" value="" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Your Password *" value="" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btnSubmit" value="Register" />
                    </div>
                    <div class="form-group">
                        <a href="#" class="ForgetPwd"
                           @click.prevent="showLoginForm">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        showLoginForm() {
            this.$emit('changeView', 'login');
        }
    }
}
</script>

<style scoped>
.register-container {
    margin-top: 5%;
    margin-bottom: 5%;
}
.register-form {
    padding: 5%;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
    background: #a976c3;
}
.register-form h3 {
    text-align: center;
    color: #fff;
}
.register-container form {
    padding: 10%;
}
.btnSubmit {
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    border: none;
    cursor: pointer;
}
input:focus {
    box-shadow: none;
}
.register-form .btnSubmit {
    font-weight: 600;
    background-color: transparent;
    color: #fff;
    border: 3px solid #fff;
    outline: none;
}
.register-form .btnSubmit:hover {
    background-color: #fff;
    color: #a976c3;
}
.register-form .ForgetPwd {
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}
</style>