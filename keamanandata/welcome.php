<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>XOR String Enkripsi</title>
    <style>
        /* ... gunakan style dari sebelumnya ... */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f9e6e7, #f7dede);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .verify-card {
            background: #fce7f0;
            padding: 50px 50px;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(234, 144, 154, 0.35);
            width: 420px;
            max-width: 90vw;
            text-align: center;
            border: 2px solid #f4b6c2;
        }

        .verify-card h2 {
            color: #d987a0;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 1.1px;
        }

        .verify-card input[type="text"] {
            width: 100%;
            padding: 16px 20px;
            margin-bottom: 22px;
            border: 2.5px solid #f4b6c2;
            border-radius: 10px;
            font-size: 16px;
            background: #ffeaf1;
            color: #a94f67;
            font-weight: 600;
            transition: border-color 0.3s ease;
            text-align: center;
        }

        .verify-card input[type="password"] {
            width: 100%;
            padding: 16px 20px;
            margin-bottom: 22px;
            border: 2.5px solid #f4b6c2;
            border-radius: 10px;
            font-size: 16px;
            background: #ffeaf1;
            color: #a94f67;
            font-weight: 600;
            transition: border-color 0.3s ease;
            text-align: center;
        }

        .verify-card input[type="text"]:focus,
        .verify-card input[type="password"]:focus {
            outline: none;
            border-color: #d987a0;
            background: #ffdae4;
        }

        .verify-card button {
            width: 100%;
            padding: 16px;
            background-color: #d987a0;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 18px;
            font-weight: 800;
            cursor: pointer;
            transition: background-color 0.3s ease;
            letter-spacing: 1px;
        }

        .verify-card button:hover {
            background-color: #b15e70;
        }

        .verify-card p.error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .result {
            margin-top: 25px;
            font-weight: 700;
            font-size: 1.3rem;
            color: #a94f67;
            word-wrap: break-word;
        }

        @media (max-width: 480px) {
            .verify-card {
                padding: 40px 25px;
                width: 90%;
            }

            .verify-card h2 {
                font-size: 1.6rem;
            }

            .verify-card button {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="verify-card">
        <h2>🔐 XOR String Enkripsi 🔐</h2>

        <input type="text" id="inputText" placeholder="Masukkan teks asli" />
        <input type="password" id="keyText" placeholder="Masukkan kunci (key)" />
        <button onclick="xorEncrypt()">Enkripsi dengan XOR</button>

        <p class="error" id="errorMsg" style="display:none;"></p>
        <p class="result" id="result"></p>

        <button onclick="xorDecrypt()" style="margin-top: 15px; background-color:#b15e70;">Dekripsi XOR</button>
        <p class="result" id="resultDecrypt"></p>
    </div>

    <script>
        // Fungsi XOR string dengan key
        function xorStrings(str, key) {
            let output = '';
            for (let i = 0; i < str.length; i++) {
                // XOR charCode tiap karakter dengan charCode key (ulang sesuai panjang key)
                let charCode = str.charCodeAt(i) ^ key.charCodeAt(i % key.length);
                output += String.fromCharCode(charCode);
            }
            return output;
        }

        // Encode output ke base64 supaya aman tampil dan bisa dikirim
        function toBase64(str) {
            return btoa(unescape(encodeURIComponent(str)));
        }

        // Decode base64 ke string asli
        function fromBase64(str) {
            return decodeURIComponent(escape(atob(str)));
        }

        function xorEncrypt() {
            const text = document.getElementById('inputText').value;
            const key = document.getElementById('keyText').value;
            const errorMsg = document.getElementById('errorMsg');
            const result = document.getElementById('result');
            const resultDecrypt = document.getElementById('resultDecrypt');

            errorMsg.style.display = 'none';
            result.textContent = '';
            resultDecrypt.textContent = '';

            if (!text) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Teks asli harus diisi!';
                return;
            }
            if (!key) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Kunci (key) harus diisi!';
                return;
            }

            // XOR string dengan key
            const encrypted = xorStrings(text, key);
            const encryptedBase64 = toBase64(encrypted);

            result.textContent = `Hasil enkripsi (base64): ${encryptedBase64}`;
        }

        function xorDecrypt() {
            const encryptedBase64 = document.getElementById('result').textContent.replace('Hasil enkripsi (base64): ', '');
            const key = document.getElementById('keyText').value;
            const errorMsg = document.getElementById('errorMsg');
            const resultDecrypt = document.getElementById('resultDecrypt');

            errorMsg.style.display = 'none';
            resultDecrypt.textContent = '';

            if (!encryptedBase64) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Tidak ada data enkripsi untuk didekripsi.';
                return;
            }
            if (!key) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Kunci (key) harus diisi!';
                return;
            }

            try {
                const encrypted = fromBase64(encryptedBase64);
                const decrypted = xorStrings(encrypted, key);
                resultDecrypt.textContent = `Hasil dekripsi: ${decrypted}`;
            } catch (e) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Gagal mendekripsi data. Pastikan kunci benar.';
            }
        }
    </script>
</body>

</html>