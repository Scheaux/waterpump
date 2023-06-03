<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },
};
</script>

<template>
    <v-app>
        <v-sheet max-width="300" class="mx-auto">
            <v-form validate-on="submit lazy" @submit.prevent="submit">
                <v-text-field
                    v-model="userName"
                    :rules="rules"
                    label="User name"
                ></v-text-field>

                <v-btn
                    :loading="loading"
                    type="submit"
                    block
                    class="mt-2"
                    text="Submit"
                ></v-btn>
            </v-form>
        </v-sheet>
    </v-app>
</template>
