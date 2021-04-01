
var app = new Vue({
    el: '#app',
    data: {
        ektp: [],
        db: [],
        // siakad: {},
        errorMessage: "",
        statusMessage: "",
        url: '<?= $tools->url ?><?= $tools->port ?>',
    },
    methods: {
        onEktpRead: function(data) {
            this.ektp = data
            this.errorMessage = ''

            axios.get(nikUrl, {
                params: {
                    nik: this.ektp.nik
                }
            })
            .then((response) => {
                this.db = response.data
            })
            .catch((error) => {
                this.errorMessage = "Data mahasiswa tidak ditemukan!"
            })

            // .then((response) => {
            //     var responseData = response.data
            //
            //     if (responseData.status == false) {
            //         this.errorMessage = "Data mahasiswa tidak ditemukan!"
            //     } else {
            //         siakadData = responseData.data
            //         this.db = siakadData
            //     }
            // })


            // axios.get('/api/mahasiswa', {
            //     params: {
            //         nik: this.ektp.nik
            //     }
            // })
            //     .then((response) => {
            //         var responseData = response.data
            //
            //         if (responseData.status == false) {
            //             this.errorMessage = "Data mahasiswa tidak ditemukan!"
            //         } else {
            //             siakadData = responseData.data
            //             siakadData.status = siakadData.is_registered ? 'Sudah Registrasi' : 'Belum Registrasi'
            //             siakadData.status = siakadData.is_alumni ? 'Alumni' : siakadData.status
            //             this.siakad = siakadData
            //         }
            //     })
        },

        // submitItem(evt){
        //   evt.preventDefault();
        //   document.getElementById("form-mahasiswa").submit();
        // },

        refreshUrl: function() {
          var conn = new WebSocket(this.url)
          this.statusMessage = ''

          conn.onmessage = (e) => {
              var data = JSON.parse(e.data)
              data.alamatLengkap = data.alamat + ' '
              data.alamatLengkap += 'RT ' + data.nomorRt + '/'
              data.alamatLengkap += 'RW ' + data.nomorRw + ' '
              data.alamatLengkap += data.namaKelurahan + ', '
              data.alamatLengkap += data.namaKecamatan + ', '
              data.alamatLengkap += data.namaKabupaten + ', '
              data.alamatLengkap += data.namaProvinsi
              console.log(data)
              this.onEktpRead(data)
              console.log("testing...")
          }

          conn.onopen = (e) => {
              this.statusMessage = "Connection established!"
          }

          conn.onerror = (e) => {
              this.statusMessage = "koneksi gagal!"
          }
        }
    },
    created: function() {
        this.refreshUrl()

    }

})
