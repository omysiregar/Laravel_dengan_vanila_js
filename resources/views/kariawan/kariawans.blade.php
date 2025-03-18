@extends('layouts.app')
@section('content')
    <?php
    function hitungUmur($tanggalLahir)
    {
        $today = new DateTime();
        $birthDate = new DateTime($tanggalLahir);
        $umur = $today->diff($birthDate);

        return $umur->y;
    }
    ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        thead {
            background-color: navy;
            color: white;
            font-size: 2em;
        }

        .form-container {
            background: white;
            padding: 20px;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-right: 50px;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f1f1f1;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #6c63ff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #5a54e0;
        }

        .grid_letak {
            justify-content: start;
            display: flex;
        }

        @media (max-width: 1198px) {
            .grid_letak {
                justify-content: start;
                display: grid;
            }
        }
    </style>
    <div class="container mt-2">
        <div class="grid_letak">
            <div class="form-container">
                <h2>Form kariawan</h2>
                <form id="karyawanForm">
                    @csrf
                    <input type="text" name="nama" id="nama" placeholder="Masukkan nama" required>
                    <input type="text" name="nomor_identifikasi" id="nomor_identifikasi"
                        placeholder="Masukkan No.identifikasi" required>
                    <input type="text" name="alamat" id="alamat" placeholder="Masukkan Alamat" required>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Masukkan Tempat Lahir"
                        required>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="Masukkan Tempat Lahir"
                        required><br>
                    <select name="pekerjaan" id="pekerjaan">
                        <option value="">Pilih Pekerjaan</option>
                        <option value="Unemployed">Unemployed</option>
                        <option value="Programmer">Programmer</option>
                        <option value="Designer">Designer</option>
                        <option value="Architect">Architect</option>
                        <option value="Artist">Artist</option>
                    </select><br>
                    <button type="submit">Simpan</button>
                </form>
            </div>
            <div style="width: 100%;">
                <h2>Daftar Karyawan</h2>
                <table border="1">
                    <thead>
                        <tr>
                            {{-- <th>No.</th> --}}
                            <th style="width: 30%;">Nama</th>
                            {{-- <th>Nomor Identifikasi</th> --}}
                            <th style="width: 10%;">Umur</th>
                            <th style="width: 40%;">Alamat</th>
                            <th style="width: 20%;">Pekerjaan</th>
                            {{-- <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th> --}}
                        </tr>
                    </thead>
                    <tbody id="karyawanTableBody">
                        <?php $no = 1; ?>
                        @foreach ($kariawans as $karyawan)
                            <tr style="font-size: 1em;">
                                {{-- <td>{{ $no++ }}</td> --}}
                                {{-- <td>{{ $karyawan->id }}</td> --}}
                                <td style="text-align: right;">{{ $karyawan->nama }}</td>
                                {{-- <td>{{ $karyawan->nomor_identifikasi }}</td> --}}
                                <td style="text-align: center;font-size: 1.2em;">{{ hitungUmur($karyawan->tanggal_lahir) }}
                                </td>
                                <td>{{ $karyawan->alamat }}</td>
                                <td style="text-align: right;">{{ $karyawan->pekerjaan }}</td>
                                {{-- <td>{{ $karyawan->tempat_lahir }}</td>
                                <td>{{ $karyawan->tanggal_lahir }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            loadKaryawan();
            document.getElementById("karyawanForm").addEventListener("submit", function(e) {
                e.preventDefault();
                insertKaryawan();
            });
        });

        function insertKaryawan() {
            let form = document.getElementById("karyawanForm");
            let formData = new FormData(form);

            // Reset pesan error sebelum mengirim data
            document.querySelectorAll(".error-message").forEach(el => el.innerHTML = "");

            fetch("{{ route('karyawan.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        // Tampilkan pesan error di bawah input terkait berdasarkan "name"
                        for (const key in data.errors) {
                            let inputField = document.querySelector(`[name="${key}"]`);
                            if (inputField) {
                                let errorElement = inputField.nextElementSibling; // Ambil elemen berikutnya (div error)
                                if (errorElement && errorElement.classList.contains("error-message")) {
                                    errorElement.innerHTML = data.errors[key][0]; // Tampilkan error pertama
                                }
                            }
                        }
                    } else {
                        alert(data.message);
                        loadKaryawan();
                        form.reset();
                    }
                })
                .catch(error => console.error("Error:", error));
                console.log(response);
                console.log(data);
        }


        function loadKaryawan() {
            fetch("{{ route('karyawan.data') }}")
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    let tableBody = document.getElementById("karyawanTableBody");
                    tableBody.innerHTML = "";

                    data.forEach(karyawan => {
                        let row = `
                            <tr style="font-size: 1em;">
                                <td style="text-align: right;">${karyawan.nama}</td>
                                <td style="text-align: center;font-size: 1.2em;">${hitungUmur(karyawan.tanggal_lahir)}</td>
                                <td >${karyawan.alamat}</td>
                                <td style="text-align: right;">${karyawan.pekerjaan}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error("Error:", error));
        }

        function hitungUmur(tanggalLahir) {
            let today = new Date(); // Tanggal hari ini
            let birthDate = new Date(tanggalLahir); // Konversi input ke tipe Date

            let umur = today.getFullYear() - birthDate.getFullYear();
            let bulan = today.getMonth() - birthDate.getMonth();
            let hari = today.getDate() - birthDate.getDate();

            // Jika bulan lahir lebih besar dari bulan saat ini atau
            // tanggal lahir lebih besar dari tanggal saat ini di bulan yang sama
            if (bulan < 0 || (bulan === 0 && hari < 0)) {
                umur--; // Kurangi umur karena belum ulang tahun tahun ini
            }

            return umur;
        }
    </script>
@endsection
