<template>
    <v-sheet width="720" class="mx-auto">
        <v-form fast-fail @submit.prevent>
            <v-text-field
                v-model="email"
                label="Email"
                prepend-inner-icon="mdi-email-outline"
            ></v-text-field>

            <v-text-field
                v-model="password"
                label="Пароль"
                type="password"
                prepend-inner-icon="mdi-lock-outline"
            ></v-text-field>
            <v-btn
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                @click="handleSubmit"
            >
                Войти
            </v-btn>

            <v-alert
                v-model="alert"
                border="start"
                variant="tonal"
                closable
                close-label="Close Alert"
                color="deep-purple-accent-4"
                title="Неудачная попытка авторизации"
            >
                Возможно введены неверные данные
            </v-alert>
        </v-form>
    </v-sheet>
</template>

<script>
import axios from 'axios';
import pass from '../../assets/pass.png';

export default {
    data() {
        return {
            email: '',
            password: '',
            pass,
            alert: false,
        };
    },
    methods: {
        async handleSubmit() {
            const response = await axios
                .post('/api/login', {
                    email: this.email,
                    password: this.password,
                })
                .catch(() => {
                    this.alert = true;
                });
            if (response.status === 200) {
                localStorage.setItem('ACCESS_TOKEN', response.data);
                this.$router.push('/');
            }
        },
    },
};
</script>
