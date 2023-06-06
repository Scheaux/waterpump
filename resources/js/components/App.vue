<template>
    <v-card width="960" class="mx-auto">
        <v-tabs v-model="tab" bg-color="indigo">
            <v-tab value="change_rate">Тариф и показания</v-tab>
            <v-tab value="residents">Дачники</v-tab>
            <v-tab value="bills">Счета</v-tab>
            <div class="exit-form">
                <span class="text-h6">{{ user?.name }}</span>
                <v-btn
                    variant="tonal"
                    prepend-icon="mdi-exit-run"
                    @click="logout"
                    >Выйти</v-btn
                >
            </div>
        </v-tabs>

        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="change_rate">
                    <v-sheet>
                        <v-select
                            v-model="select"
                            label="Месяц"
                            :items="periods"
                            return-object
                            variant="solo"
                        ></v-select>
                        <div v-if="select" class="water-form">
                            <v-text-field
                                v-model="select.rate_rub"
                                :label="`Цена за кубометр воды за период: ${
                                    select?.title || ''
                                }`"
                            ></v-text-field>
                            <v-btn
                                color="blue"
                                size="x-large"
                                variant="tonal"
                                prepend-icon="mdi-cloud-refresh"
                                @click="saveRate"
                            >
                                Сохранить
                            </v-btn>
                        </div>
                        <div v-if="select" class="water-form">
                            <v-text-field
                                v-model="select.amount_volume"
                                :label="`Показания счетчика за период: ${
                                    select?.title || ''
                                }`"
                            ></v-text-field>
                            <v-btn
                                color="blue"
                                size="x-large"
                                variant="tonal"
                                prepend-icon="mdi-cloud-refresh"
                                @click="saveRecords"
                            >
                                Сохранить
                            </v-btn>
                        </div>
                    </v-sheet>
                </v-window-item>
                <Residents v-if="tab === 'residents'" />
                <Bills :periods="periods" />
            </v-window>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/dist/locale/ru';
import Residents from './Residents.vue';
import Bills from './Bills.vue';

export default {
    data() {
        return {
            select: null,
            tab: null,
            waterRate: null,
            periods: [],
            records: [],
            user: null,
        };
    },
    created() {
        if (!localStorage.getItem('ACCESS_TOKEN')) {
            this.$router.push('/login');
        } else {
            axios
                .get('/api/periods', {
                    headers: this.getHeaders(),
                })
                .then((res) => {
                    this.records = res.data.records;
                    res.data.periods.forEach((period) => {
                        const record = res.data.records.find(
                            (x) => x.id === period.id
                        );
                        this.periods.push({
                            title: moment(period.begin_date * 1000)
                                .locale('ru')
                                .format('YYYY MMMM'),
                            id: period.id,
                            begin_date: period.begin_date,
                            end_date: period.end_date,
                            rate_rub: period.rate_rub,
                            amount_volume: record?.amount_volume || null,
                        });
                    });
                });

            axios
                .get('/api/user', {
                    headers: this.getHeaders(),
                })
                .then((res) => {
                    this.user = res.data;
                });
        }
    },
    components: {
        Residents,
        Bills,
    },
    methods: {
        getHeaders() {
            return {
                Authorization: `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
            };
        },
        logout() {
            axios
                .post('/api/logout', {}, { headers: this.getHeaders() })
                .then(() => {
                    localStorage.removeItem('ACCESS_TOKEN');
                    this.$router.push('/login');
                });
        },
        saveRate() {
            axios.patch(
                `/api/periods/${this.select.id}`,
                {
                    rate_rub: this.select.rate_rub,
                },
                { headers: this.getHeaders() }
            );
        },
        saveRecords() {
            let method = 'POST';
            if (this.records.find((x) => x.id === this.select.id)) {
                method = 'PATCH';
            }
            axios.request({
                url: '/api/pumprecords',
                headers: this.getHeaders(),
                method,
                data: {
                    amount_volume: this.select.amount_volume,
                    period_id: this.select.id,
                },
            });
        },
    },
};
</script>

<style scoped>
.water-form {
    display: flex;
    gap: 10px;
}

.exit-form {
    position: absolute;
    right: 5px;
    top: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>
