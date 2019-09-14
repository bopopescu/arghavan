import Store from './store';
import VueClock from 'vue-clock2';
import VueRangeSlider from 'vue-range-component'
// import GateWidget from '../Components/GateWidget';

window.v = new Vue({
    el: '#app',
    store: Store,

    components: {
        VueClock,
        VueRangeSlider
    },

    data: {
        formMode: Enums.FormMode.normal,
        page: 1,
        isLoading: true,
        insertMode: false,
        tempRecord: {},
        connectionStatus: true,
        timeValue: [0,0],
        time: 0,
        weekdays: [
            { index: 0, values: [390, 1020], name: 'شنبه' },
            { index: 1, values: [390, 1020], name: 'یکشنبه' },
            { index: 2, values: [390, 1020], name: 'دوشنبه' },
            { index: 3, values: [390, 1020], name: 'سه شنبه' },
            { index: 4, values: [390, 1020], name: 'چهارشنبه' },
            { index: 5, values: [390, 1020], name: 'پنج شنبه' },
            { index: 6, values: [390, 1020], name: 'جمعه' },
        ],
    },

    created() {
        this.tempRecord = this.emptyRecord;

        this.min = 0;
        this.max = 1440;
        this.enableCross = false;
        this.step = 15;
        this.tooltip = false;
        // this.data = ['0', '24']
    },

    mounted() {
        this.loadRecords(this.page);
    },

    computed: {
        isNormalMode: state => state.formMode == Enums.FormMode.normal,
        isRegisterMode: state => state.formMode == Enums.FormMode.register,

        /**
         * Generate new Empty record
         */
        emptyRecord() {
            return {
                id: 0,
                name: '',
            };
        },

        records: state => state.$store.getters.records,
        allData: state => state.$store.getters.allData,
        hasRow: state => (0 < state.records.length),
    },

    methods: {

        /**
         * Change Value Vue Slider Time
         *
         * @param      {(number|string)}  values  The values
         * @return     {Object}           { description_of_the_return_value }
         */
        changeValue(value)
        {
            var result = new Object();
            var hours1 = Math.floor(value / 60);
            var minutes1 = value - (hours1 * 60);

            if (hours1.length == 1) {
                hours1 = '0' + hours1;
            }

            if (minutes1.length == 1) {
                minutes1 = '0' + minutes1;
            }

            if (minutes1 == 0) {
                minutes1 = '00';
            }

            if (hours1 >= 12) {
                if (hours1 == 12) {
                    hours1 = hours1;
                    // minutes1 = minutes1 + " بعدازظهر";
                } else {
                    hours1 = hours1 - 12;
                    // minutes1 = minutes1 + " بعدازظهر";
                }
            } else {
                hours1 = hours1;
                // minutes1 = minutes1 + " صبح";
            }

            if (hours1 == 0) {
                hours1 = 12;
                minutes1 = minutes1;
            }

            result = hours1 + ":" + minutes1;
            this.time = result;


            return result;
        },

        /**
         * Change form mode
         *
         * @parصبح      {<type>}  formMode  The form mode
         */
        changeFormMode(formMode) {
            this.formMode = formMode;
        },

        /**
         * Show Invisible items
         */
        showInvisibleItems() {
            document.querySelectorAll('.invisible')
                .forEach(item => {
                    item.classList.remove('invisible');
                });
        },

        /**
         * Clear errors
         */
        clearErrors() {
            this.errors.clear();

            document.querySelectorAll('.form-control')
                .forEach(x => {
                    $(x).removeClass('has-error')
                        .parent()
                        .addClass('label-floating is-empty');
                });
        },


        /**
         * Hide insert/update modal
         */
        registerCancel() {
            this.tempRecord = this.emptyRecord;

            this.changeFormMode(Enums.FormMode.normal);
        },

        /**
         * Load Records list
         */
        loadRecords(page) {

            this.page = page;
            this.isLoading = true;

            this.$store.dispatch('loadRecords', page)
                .then(res => {
                    this.showInvisibleItems();
                    this.isLoading = false;
                })
                .catch(err => {
                    this.isLoading = false;

                    this.showInvisibleItems();
                });
        },
        /**
         * New record dialog
         */
        newRecord() {
            this.clearErrors();
            this.tempRecord = $.extend(true, {}, this.emptyRecord);
            this.changeFormMode(Enums.FormMode.register);
           // this.setRangeSlider();
        },

        /**
         * Edit a record
         */
        editRecord(record) {
            this.clearErrors();

            this.tempRecord = {
                id: record.id,
                name: record.name,
            };
            this.formMode = Enums.FormMode.register;
        },

        /**
         * Prepare to delete
         */
        readyToDelete(record) {
            this.tempRecord = record;
        },
        /**
         * Delete a record
         */
        deleteRecord() {
            this.isLoading = true;

            this.$store.dispatch('deleteRecord', this.tempRecord.id)
                .then(res => {
                    this.isLoading = false;

                    demo.showNotification('حذف رکورد با موفقیت انجام شد', 'success');
                    this.tempRecord = {};
                })
                .catch(err => {
                    demo.showNotification('خطا در حذف رکورد! این خطا در سامانه ذخیره شد و مورد بررسی قرار خواهد گرفت', 'danger');
                });
        },
        /**
         * Save record
         */
        saveRecord() {
            // this.$validator.validateAll()
            //     .then(result => {
            //         if (result) {
                        // Prepare data
                        console.log('this.weekdays', this.weekdays);
                        let data = {
                            id: this.tempRecord.id,
                            name: this.tempRecord.name,
                            weekdays: [],
                        };

                        data.weekdays = this.weekdays.filter(el => el.checked == true);
                        data.weekdays.forEach(weekday => {
                            weekday.begin = this.changeValue(weekday.values[0]);;
                            weekday.end = this.changeValue(weekday.values[1]);;
                        });

                        console.log('data', data);
                        this.isLoading = true;

                        // Try to save
                        this.$store.dispatch('saveRecord', data)
                            .then(res => {
                                this.isLoading = false;

                                if (res) {
                                    demo.showNotification('ثبت اطلاعات با موفقیت انجام شد', 'success');

                                    this.registerCancel();
                                } else {
                                    demo.showNotification('این نام قبلا ثبت شده است', 'warning');
                                }
                            })
                            .catch(err => {
                                this.isLoading = false;

                                if (err.response.status) {
                                    demo.showNotification('این نام قبلا ثبت شده است', 'danger');
                                }
                                else {
                                    demo.showNotification(err.message, 'danger');
                                }
                            });

                        return;
                    }
                   let err = Helper.generateErrorString();

                    demo.showNotification(err, 'warning');
                // });
        },
    },



})
