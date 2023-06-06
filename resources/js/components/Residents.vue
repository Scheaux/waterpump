<template>
    <v-window-item value="residents">
        <v-sheet>
            <v-dialog v-model="dialog" width="auto">
                <template v-slot:activator="{ props }">
                    <v-btn
                        color="primary"
                        v-bind="props"
                        prepend-icon="mdi-account-plus-outline"
                    >
                        Добавить
                    </v-btn>
                </template>

                <v-card class="pa-6" min-width="560">
                    <v-text-field
                        v-model="newResident.fio"
                        label="ФИО"
                    ></v-text-field>
                    <v-text-field
                        v-model="newResident.area"
                        label="Площадь"
                    ></v-text-field>
                    <v-text-field
                        v-model="newResident.start_date"
                        label="Дата регистрации"
                    ></v-text-field>
                    <v-card-actions>
                        <v-btn color="primary" size="large" @click="addResident"
                            >Сохранить</v-btn
                        >
                        <v-btn
                            color="danger"
                            size="large"
                            @click="dialog = false"
                            >Закрыть</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-expansion-panels v-model="selectedResident">
                <v-expansion-panel
                    v-for="resident in paginator?.data"
                    :value="resident"
                >
                    <v-expansion-panel-title>
                        <v-row no-gutters>
                            <v-col cols="4" class="d-flex justify-start">
                                {{ resident.fio }}
                            </v-col>
                            <v-col cols="4">
                                Площадь: {{ resident.area }}
                            </v-col>
                            <v-col cols="4">
                                {{ resident.start_date }}
                            </v-col>
                        </v-row>
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <v-text-field
                            label="ФИО"
                            v-model="resident.fio"
                        ></v-text-field>

                        <v-text-field
                            label="Площадь участка"
                            v-model="resident.area"
                        ></v-text-field>

                        <v-text-field
                            label="Дата подключения"
                            v-model="resident.start_date"
                        ></v-text-field>
                        <div class="extended-settings">
                            <v-btn
                                color="blue"
                                size="x-large"
                                variant="tonal"
                                prepend-icon="mdi-cloud-refresh"
                                @click="saveResident"
                            >
                                Сохранить
                            </v-btn>
                        </div>
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>

            <v-pagination
                v-model="page"
                :length="paginator?.last_page"
            ></v-pagination>
        </v-sheet>
    </v-window-item>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    data() {
        return {
            page: 1,
            paginator: null,
            selectedResident: null,
            newResident: {},
            dialog: false,
            moment,
        };
    },
    watch: {
        page() {
            this.getResidents();
        },
    },
    mounted() {
        this.getResidents();
    },
    methods: {
        getHeaders() {
            return {
                Authorization: `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
            };
        },
        getUnix(date) {
            return moment(date, 'DD.MM.YYYY').unix();
        },
        getResidents() {
            axios
                .get(`/api/residents?page=${this.page}`, {
                    headers: this.getHeaders(),
                })
                .then((res) => {
                    res.data.data.map(
                        (x) =>
                            (x.start_date = moment(x.start_date * 1000).format(
                                'DD.MM.YYYY'
                            ))
                    );
                    this.paginator = res.data;
                });
        },
        saveResident() {
            axios.patch(
                `/api/residents/${this.selectedResident.id}`,
                {
                    fio: this.selectedResident.fio,
                    area: this.selectedResident.area,
                    start_date: this.getUnix(this.selectedResident.start_date),
                },
                { headers: this.getHeaders() }
            );
        },
        addResident() {
            axios
                .post(
                    '/api/residents',
                    {
                        fio: this.newResident.fio,
                        area: this.newResident.area,
                        start_date: this.getUnix(this.newResident.start_date),
                    },
                    { headers: this.getHeaders() }
                )
                .then(() => {
                    this.newResident = {};
                    this.dialog = false;
                });
        },
    },
};
</script>

<style scoped>
.extended-settings {
    display: flex;
    gap: 10px;
}
</style>
