<!DOCTYPE html>
<html>
<head>
    <title>Test Laporan Kesehatan</title>
</head>
<body>
    <h1>Testing Laporan Kesehatan Access</h1>
    
    <p>Clicking button below to access laporan kesehatan...</p>
    
    <button onclick="testLaporan()">Test Laporan Kesehatan</button>
    <button onclick="window.location.href='/laporan/kesehatan'">Direct Access</button>
    
    <div id="result" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
        Result will appear here...
    </div>
    
    <script>
    function testLaporan() {
        fetch('/laporan/kesehatan')
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.text();
            })
            .then(html => {
                console.log('HTML length:', html.length);
                console.log('First 500 chars:', html.substring(0, 500));
                
                if (html.includes('Laporan Kesehatan')) {
                    document.getElementById('result').innerHTML = '<p style="color: green;">✓ Laporan kesehatan BERHASIL dimuat!</p><p>Content length: ' + html.length + ' bytes</p>';
                } else if (html.includes('login')) {
                    document.getElementById('result').innerHTML = '<p style="color: orange;">⚠ Diarahkan ke halaman login - silakan login terlebih dahulu</p>';
                } else {
                    document.getElementById('result').innerHTML = '<p style="color: red;">✗ Response tidak mengandung laporan kesehatan</p><p>' + html.substring(0, 200) + '...</p>';
                }
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p style="color: red;">✗ Error: ' + error.message + '</p>';
                console.error('Error:', error);
            });
    }
    
    // Auto test on load
    window.onload = function() {
        setTimeout(testLaporan, 1000);
    };
    </script>
</body>
</html>
