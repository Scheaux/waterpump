<template>
    <v-window-item value="bills">
        <v-select
            v-model="select"
            label="Месяц"
            :items="periods"
            return-object
            variant="solo"
        ></v-select>

        <v-sheet>
            <v-expansion-panels>
                <v-expansion-panel v-for="bill in bills">
                    <v-expansion-panel-title>
                        <v-row no-gutters>
                            <v-col cols="4" class="d-flex justify-start">
                                {{ bill.resident.fio }}
                            </v-col>
                        </v-row>
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <div>Имя: {{ bill.resident.fio }}</div>
                        <div>Площадь: {{ bill.resident.area }}</div>
                        <div>Сумма: {{ bill.amount_rub }} рублей</div>
                        <div>
                            Дата получения счета:
                            {{ moment(bill.created_at).format('DD.MM.YYYY') }}
                        </div>
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>

            <v-pagination
                v-if="select && bills.length > 0"
                v-model="page"
                :length="paginator.last_page"
            ></v-pagination>

            <div
                v-if="select && bills.length === 0"
                class="text-h4 text-center"
            >
                Нету счетов
            </div>
        </v-sheet>
    </v-window-item>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    props: ['periods'],
    data() {
        return {
            page: 1,
            select: null,
            paginator: null,
            bills: [],
            moment,
        };
    },
    watch: {
        select() {
            this.getBills();
        },
        page() {
            this.getBills();
        },
    },
    methods: {
        getHeaders() {
            return {
                Authorization: `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
            };
        },
        getBills() {
            axios
                .get(
                    `/api/bills?page=${this.page}&period_id=${this.select.id}`,
                    {
                        headers: this.getHeaders(),
                    }
                )
                .then((res) => {
                    console.log(res);
                    this.paginator = res.data;
                    this.bills = res.data.data;
                });
        },
    },
};
</script>
