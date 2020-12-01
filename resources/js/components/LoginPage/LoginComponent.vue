<template>
    <div class="container">
        <div class="card login">
            <div class="slider card-content">
                <img
                    class="gambarSlide"
                    src="/images/slider_login_/background_1.jpg"
                    alt="background 1"
                />
                <img
                    class="gambarSlide"
                    src="/images/slider_login_/background_2.jpg"
                    alt="background 2"
                />
                <img
                    class="gambarSlide"
                    src="/images/slider_login_/background_3.jpg"
                    alt="background 3"
                />
            </div>
            <div class="form">
                <h2>Login</h2>
                <p class="text-sambutan">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Molestiae in similique veritatis dolores ipsum reiciendis
                    iure fugiat dolorum labore animi aut deserunt et
                    consequuntur earum non quam, perferendis ad quas.
                </p>
                <p class="invalid" v-show="isInvalidLogin" v-html="invalidLoginFeedback">
                            
                        </p>
                <form class="vertical-center" id="login-form">
                    <div class="container">
                        <input
                            type="email"
                            name="emailLogin"
                            id="emailLogin"
                            placeholder="email..."
                            autocomplete="off"
                            v-on:keyup="validasi('email', $event)"
                            v-model="datainput.inputemail_login"
                        />
                        <p class="invalid" v-show="isInvalid.emailLogin">
                            format email tidak valid
                        </p>
                    </div>
                    <div class="container">
                        <input
                            type="password"
                            name="passwordLogin"
                            id="paswordLogin"
                            placeholder="password"
                            v-on:keyup="validasi('password', $event)"
                            v-model="datainput.inputpassword_login"
                        />
                    </div>
                    <div class="container">
                        <input
                            type="checkbox"
                            name="rememberme"
                            id="rememberme"
                        /><span>Ingat Saya</span>
                    </div>
                    <div class="container-tombol">
                        <button
                            class="tombol"
                            v-on:click.prevent="handleLogin()"
                        >
                            Login
                        </button>

                        <button
                            class="tombol"
                            id="modal-button"
                            v-on:click.prevent="daftar = !daftar"
                        >
                            Daftar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="popup" id="popup" v-show="daftar">
            <div class="popup-header">
                <h2>Jangan lupa salim sama ibu!</h2>
                <span class="tutupPopup" v-on:click="handleClosePopup()"
                    >X</span
                >
            </div>
            <div class="popup-content">
                <form id="form-daftar">
                    <div class="container">
                        <input
                            type="text"
                            name="nama"
                            id="nama"
                            required
                            autocomplete="off"
                            placeholder="Username akun..."
                            v-on:keyup="validasi('nama', $event)"
                            v-model="datainput.inputname_daftar"
                        />
                        <p
                            class="invalid"
                            v-show="isInvalid.name"
                            v-html="invalidLengthName"
                        >
                            nama <b>{{ datainput.inputname_daftar }}</b> sudah
                            terdaftar
                        </p>
                    </div>
                    <div class="container">
                        <input
                            type="text"
                            name="email"
                            id="email"
                            required
                            autocomplete="off"
                            placeholder="email login..."
                            v-on:keyup="validasi('email', $event)"
                            v-model="datainput.inputemail_daftar"
                        />
                        <p
                            class="invalid"
                            v-show="isInvalid.email"
                            v-html="invalidEmail"
                        >
                            email <b>{{ datainput.inputemail_daftar }}</b> sudah
                            terdaftar
                        </p>
                    </div>
                    <div class="container">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="password..."
                            v-model="datainput.inputpassword_daftar"
                            v-on:keyup="validasi('password', $event)"
                        />
                    </div>
                    <div class="container">
                        <input
                            type="password"
                            name="password-konfirmasi"
                            id="password-konfirmasi"
                            required
                            placeholder="password konfirmasi..."
                            v-model="datainput.passwordkonfirmasi"
                            v-on:keyup="validasi('password', $event)"
                        />
                        <p
                            class="invalid"
                            v-show="isInvalid.passwordkonfirmasi"
                        >
                            password tidak sama
                        </p>
                    </div>
                    <div class="loading" v-show="loading"></div>
                    <div class="container">
                        <div
                            class="success"
                            v-html="successdaftar"
                            v-show="showSuccess"
                        ></div>
                        <button
                            class="daftar-btn"
                            v-on:click.prevent="handleDaftar()"
                            v-show="showButton"
                        >
                            Daftarkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["csrf"],
    data() {
        return {
            index: 0,
            daftar: false,
            isInvalid: {
                name: false,
                email: false,
                passwordkonfirmasi: false,
                emailLogin: false
            },
            disabled: true,
            datainput: {
                inputname_daftar: "",
                inputemail_daftar: "",
                inputpassword_daftar: undefined,
                passwordkonfirmasi: undefined,
                inputpassword_login: undefined,
                inputemail_login: ""
            },
            users: undefined,
            invalidEmail: undefined,
            invalidLengthName: undefined,
            loading: false,
            showButton: true,
            successdaftar: undefined,
            showSuccess: false,
            isInvalidLogin: false,
            invalidLoginFeedback: undefined
        };
    },
    mounted() {
        this.showSlide();
        this.getDataUser();
    },
    methods: {
        showSlide: function() {
            let i;
            var gambar = document.getElementsByClassName("gambarSlide");

            for (i = 0; i < gambar.length; i++) {
                gambar[i].style.display = "none";
            }
            this.index++;
            if (this.index > gambar.length) {
                this.index = 1;
            }
            gambar[this.index - 1].style.display = "block";
            setTimeout(this.showSlide, 10000);
        },
        getDataUser() {
            axios.get("/api/users_data_").then(response => {
                this.users = response.data;
            });
        },
        validasi(who, event) {
            if (who === "nama") {
                if (this.cekTersedia("nama").name !== undefined) {
                    this.isInvalid.name = true;
                } else {
                    if (this.datainput.inputname_daftar.length > 6) {
                        this.isInvalid.name = false;
                    } else {
                        this.invalidLengthName = `<i>panjang minimal username minimal 6 karakter</i>`;
                        this.isInvalid.name = true;
                    }
                }
            } else if (who === "email") {

                console.log(!this.validasiEmail("login"));
                if (event.target.getAttribute("id") == "emailLogin") {
                    if (!this.validasiEmail("login")) {
                        if (this.datainput.inputemail_login !== "") {
                            this.isInvalid.emailLogin = true;
                        } else {
                            this.isInvalid.emailLogin = false;
                        }
                    } else {
                        this.isInvalid.emailLogin = false;
                    }
                } else {
                    if (!this.validasiEmail("daftar")) {
                        if (this.datainput.inputemail_daftar !== "") {
                            this.isInvalid.email = true;
                            this.invalidEmail = `<b>format email tidak valid</b>`;
                        } else {
                            this.isInvalid.email = false;
                        }
                    } else {
                        this.isInvalid.email = false;
                        if (this.cekTersedia("email").email !== undefined) {
                            this.isInvalid.email = true;
                        } else {
                            this.isInvalid.email = false;
                        }
                    }
                }
            } else {
                this.validasiPassword();
            }
        },
        cekTersedia(buat) {
            let name = [];
            let email = [];
            if (buat === "nama") {
                this.users.map(element => {
                    name.push(element.name);
                });
            } else {
                this.users.map(element => {
                    email.push(element.email);
                });
            }

            return {
                name: name.find(
                    ele => ele === this.datainput.inputname_daftar.toString()
                ),
                email: email.find(
                    ele => ele === this.datainput.inputemail_daftar.toString()
                )
            };
        },
        validasiPassword() {
            if (
                this.datainput.inputpassword_daftar !== undefined &&
                this.datainput.passwordkonfirmasi !== undefined
            ) {
                if (
                    this.datainput.inputpassword_daftar !==
                    this.datainput.passwordkonfirmasi
                ) {
                    this.isInvalid.passwordkonfirmasi = true;
                } else {
                    this.isInvalid.passwordkonfirmasi = false;
                }
            }
        },
        validasiEmail(siapa) {
            let emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
            let valid = false;
            if (siapa == "login") {
                if (this.datainput.inputemail_login.match(emailRegex)) {
                    valid = true;
                }
            } else {
                if (this.datainput.inputemail_daftar.match(emailRegex)) {
                    valid = true;
                }
            }
            return valid;
        },
        validData() {
            if (
                this.datainput.inputemail_daftar !== "" &&
                this.datainput.inputname_daftar !== "" &&
                this.datainput.inputpassword_daftar !== undefined &&
                this.datainput.passwordkonfirmasi !== undefined
            ) {
                if (
                    !this.isInvalid.name &&
                    !this.isInvalid.email &&
                    !this.isInvalid.passwordkonfirmasi
                ) {
                    return true;
                } else {
                    return false;
                }
            } else if (this.datainput.inputpassword_login !== undefined) {
                return true;
            } else {
                return false;
            }
        },
        handleDaftar() {
            if (this.validData()) {
                this.loading = true;
                this.showButton = false;
                const form = document.querySelector("#form-daftar");
                const data = new FormData(form);
                data.append("csrf_token", this.csrf);
                axios
                    .post("/api/register_", data, {
                        headers: {
                            "X-CSRF-TOKEN": this.csrf
                        }
                    })
                    .then(response => {
                        if (response.status === 200) {
                            this.successdaftar = `<p>Ayoo, satu langkah lagi! kami telah mengirim email verifikasi ke ${this.datainput.inputemail_daftar}, Silahkan cek email untuk verifikasi akun!</p>`;
                            this.loading = false;
                            let form = document.querySelector("#form-daftar");
                            this.formReset();
                            form.reset();
                            this.showSuccess = true;
                        }
                        console.log(response);
                    })
                    .catch(error => {
                        console.log("Errorrrrr: " + error);
                    });
            } else {
                alert("data tidak valid");
            }
        },
        handleClosePopup() {
            const form = document.querySelector("#form-daftar");
            this.loading = false;
            this.formReset();
            form.reset();
            return (this.daftar = !this.daftar);
        },
        formReset() {
            this.datainput.inputemail_daftar = "";
            this.datainput.inputpassword_daftar = "";
            this.datainput.inputname_daftar = "";
            this.datainput.passwordkonfirmasi = "";

            this.isInvalid.name = false;
            this.isInvalid.email = false;
            this.isInvalid.passwordkonfirmasi = false;
        },
        handleLogin() {
            if (this.validData()) {
                let loginForm = document.querySelector("#login-form");
                let dataLogin = new FormData(loginForm);
                axios
                    .post("/login", dataLogin, {
                        headers: {
                            "X-CSRF-TOKEN": this.csrf
                        }
                    })
                    .then(response => {
                        if(response.status === 200){
                            console.log(response.data.url);
                            return window.location.href = '/home';
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 400){
                            this.isInvalidLogin = true;
                           this.invalidLoginFeedback = `<b>${error.response.data.pesan}</b>`;
                        }
                    });
            }
        }
    }
};
</script>
