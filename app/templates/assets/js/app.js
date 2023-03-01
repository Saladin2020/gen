const app = Vue.createApp({
    data() {
        return {
            seldb: "",
            seltable: "",
            selcolumn: "",
            databaselist: [],
            tablelist: [],
            columnlist: [],
            content: [],
            queryString: "",
            dataset: [],
            result: [],

            joinSymbol: "off"
        }
    },
    mounted() {
        this.loadDatabase()
    },
    methods: {
        loadDatabase() {
            post_data = {
                username: "this.user_name_input",
                password: "this.password_input"
            }
            axios.post('./databases', post_data)
                .then(response => {
                    console.log(response)
                    if (response.data.message == "success") {
                        this.databaselist = response.data.body
                    } else {
                        this.result = response.data.message
                    }

                })
                .catch(error => {
                    this.result = error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                        confirmButtonColor: 'black',
                    })
                })
        },


        loadTable(event) {
            console.log(this.seldb)
            post_data = {
                databasename: event.target.value,
            }
            axios.post('./tables', post_data)
                .then(response => {
                    console.log(response)
                    if (response.data.message == "success") {
                        this.tablelist = response.data.body
                        this.content = []
                        this.seltable = ""
                        this.selcolumn = ""
                    } else {
                        this.result = response.data.message
                    }

                })
                .catch(error => {
                    this.result = error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                        confirmButtonColor: 'black',
                    })
                })
        },

        loadColumn(event) {
            post_data = {
                databasename: this.seldb,
                tablename: this.seltable
            }
            axios.post('./columns', post_data)
                .then(response => {
                    console.log(response)
                    if (response.data.message == "success") {
                        this.columnlist = response.data.body
                        this.content = []
                        this.selcolumn = ""

                    } else {
                        this.result = response.data.message
                    }

                })
                .catch(error => {
                    this.result = error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                        confirmButtonColor: 'black',
                    })
                })
        },

        process() {
            post_data = {
                databasename: this.seldb,
                tablename: this.seltable,
                columnname: this.content
            }
            axios.post('./process', post_data)
                .then(response => {
                    console.log(response)
                    if (response.data.message == "success") {
                        this.queryString = response.data.body
                    } else {
                        this.result = response.data.message
                    }

                })
                .catch(error => {
                    this.result = error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                        confirmButtonColor: 'black',
                    })
                })
        },

        run() {
            post_data = {
                databasename: this.seldb,
                tablename: this.seltable,
                query: this.queryString
            }
            axios.post('./run', post_data)
                .then(response => {
                    console.log(response)
                    if (response.data.message == "success") {
                        this.dataset = response.data.body
                    } else {
                        this.result = response.data.message
                    }

                })
                .catch(error => {
                    this.result = error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                        confirmButtonColor: 'black',
                    })
                })
        },

        addColumn(event) {
            if (!this.content.includes(event.target.value)) {
                if (event.target.value != '*') {
                    this.content.push(this.seltable + '.' + event.target.value)
                } else {
                    this.content = []
                    this.content.push("*")
                }
            }
            this.selcolumn = ""
        },
        removeColumn(value) {
            this.content = this.content.filter(function (ele) {
                return ele != value;
            })
            if (this.content.length == 0) {
                this.selcolumn = ""
            }
        }
    }
});
app.mount('#app');