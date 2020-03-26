
var app = new Vue({
    el: '#app',
    data: {
        ektp: [],
        siakad: {},
        errorMessage: "",
        url: '<?= $port ?>',
    },
    methods: {
        onEktpRead: function(data) {
            this.ektp = data
            this.errorMessage = ''

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

        submitItem(evt){
          evt.preventDefault();
          document.getElementById("form-registrasi").submit();
        },

        refreshUrl: function() {
          var conn = new WebSocket(this.url);
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
          };

          conn.onopen = function(e) {
              console.log("Connection established!")
          };
        }
    },
    created: function() {
        this.refreshUrl()
    }
})
