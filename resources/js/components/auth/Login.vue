<template>
    <div class="container login-container">
        <div class="row">
            <div class="col-md-10 offset-md-1 login-form">
                <h3>Login</h3>
                <form v-on:submit.prevent>
                    <div class="form-group">
                        <input type="text" v-model="inputEmail" class="form-control" placeholder="Your Email *" value="" />
                    </div>
                    <div class="form-group">
                        <input type="password" v-model="inputPassword" class="form-control" placeholder="Your Password *" value="" />
                    </div>
                    <div class="form-group">
                        <input @click="login" type="submit" class="btnSubmit login-btn btn-light" value="Login" />
                    </div>
                    <div class="form-group">
                        <a href="#" class="form-btn " value="Login">Forget Password?</a>
                    </div>
                    <div class="form-group">
                        <a class="btn-register form-btn"
                           href="#"
                           value="Login"
                           @click="showRegForm">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputEmail: '',
            inputPassword: ''
        }
    },
    methods: {
        showRegForm() {
            this.$emit('changeView', 'register');
        },

        login() {
            this.$auth.login({
                data: {
                    email: this.inputEmail,
                    password: this.inputPassword
                },
                redirect: '/home',
                fetchUser: true,
                success: function(res) {
                    //localStorage.setItem('token', res.data.access_token);
                },
                rememberMe: true
            }).catch(function(res) {
                // TODO::handle error
            });

            console.log(this.$auth.user());

            console.log(localStorage.length);
        }
    }
}
</script>

<style scoped>
.login-container {
    margin-top: 5%;
    margin-bottom: 5%;
}
.login-form {
    padding: 5%;
    background: #3490DC;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form h3{
    text-align: center;
    color: #fff;
}
.login-container form {
    padding: 10%;
}
.btnSubmit {
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    border: none;
    cursor: pointer;
}
.login-form .btnSubmit {
    font-weight: 600;
}
.login-form .form-btn {
    font-weight: 600;
    text-decoration: none;
    color: #fff;
}
.login-form .form-btn:hover {
    color: #eee;
}
.btn-register {
    color: #fff;
}
</style>