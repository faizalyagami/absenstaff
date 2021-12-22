<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h1>Login To the dashboard</h1>
                </div>
                <div class="space">
                    <Input type="email" v-model="data.email" placeholder="Email" />
                </div>
                <div class="space">
                    <Input type="password" v-model="data.password" placeholder="Password" />
                </div>
                <div class="login_footer">
                    <Button type="primary" @click="login" :disabled="isLogggin" :loading="isLogggin">{{ isLogggin ? 'Logging...' : 'Login' }}</Button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    ._1adminOverveiw_table_recent {
        margin: 0 auto;
        margin-top: 210px;
    }
    .login_footer {
        margin-top: 10px;
        text-align: center;
    }
    .login_header {
        margin-bottom: 10px;
        text-align: center;
    }
</style>

<script>
    export default {
        data() {
            return {
                data: {
                    email: '', 
                    password: ''
                }, 
                isLogggin: false
            }
        }, 
        methods: {
            async login() {
                if(this.data.email.trim() == '') return this.error('Email is required');
			    if(this.data.password.trim() == '') return this.error('Password is required');
			    if(this.data.password.length < 6) return this.error('Incorect login detail');

                this.isLogggin = true

                const res = await this.callApi('post', 'app/admin_login', this.data)
                console.log(res);
                if(res.status === 200) {
                    this.success(res.data.message)
                    window.location = '/'
                } else {
                    if(res.status === 401) {
                        this.info(res.data.message)
                    } else if(res.status === 422) {
                        if(res.data.errors) {
                            for (let i in res.data.errors) {
                                this.error(res.data.errors[i][0]);
                            }
                        }
                    } else {
                        this.swr()
                    }
                }

                this.isLogggin = false
            }
        }
    }
</script>