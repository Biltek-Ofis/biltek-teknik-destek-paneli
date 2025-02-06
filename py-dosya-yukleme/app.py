from flask import Flask, request, jsonify, send_from_directory, render_template
import os
import random
import string

app = Flask(__name__)

UPLOAD_BASE_DIR = "uploads"
ALLOWED_EXTENSIONS = {
    "jpg", "jpeg", "png", "gif", "bmp", "tiff", "webp",  # Görseller
    "mp4", "mkv", "avi", "mov", "flv", "wmv", "webm", "mpeg", "mpg"  # Videolar
}

# Dizin yoksa oluştur
os.makedirs(UPLOAD_BASE_DIR, exist_ok=True)

@app.errorhandler(404)
def page_not_found(e):
    return render_template('404.html')

def allowed_file(filename):
    return "." in filename and filename.rsplit(".", 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route("/uploads/<id>/<filename>", methods=["GET"])
def get_file(id, filename):
    directory = os.path.join(UPLOAD_BASE_DIR, id)
    file_path = os.path.join(directory, filename)

    if not os.path.exists(file_path):
        page_not_found("")

    return send_from_directory(directory, filename)

def generate_unique_filename(directory, extension):
    """Rastgele dosya adı oluşturur ve çakışma olup olmadığını kontrol eder."""
    while True:
        random_string = "".join(random.choices(string.ascii_letters + string.digits, k=10))
        new_filename = f"{random_string}.{extension}"
        file_path = os.path.join(directory, new_filename)

        if not os.path.exists(file_path):  # Dosya mevcut değilse döndür
            return new_filename


@app.route("/upload", methods=["POST"])
def index():
    response = {}
    error = False

    if "file" not in request.files:
        response["mesaj"] = "Dosya seçilmedi."
        response["basarili"] = False
        error = True
    if not error:
        file = request.files["file"]
        file_ext = file.filename.rsplit(".", 1)[1].lower() if "." in file.filename else ""

        if not allowed_file(file.filename):
            response["mesaj"] = "Dosya formatı desteklenmiyor"
            response["basarili"] = False
            error = True
        if not error:
            id_param = request.form.get("id")
            if not id_param:
                response["mesaj"] = "Cihaz bulunmuyor"
                response["basarili"] = False
                error = True
            if not error:
                # Klasör oluştur
                upload_path = os.path.join(UPLOAD_BASE_DIR, id_param)
                os.makedirs(upload_path, exist_ok=True)

                # Çakışma kontrolü yaparak benzersiz dosya adı oluştur
                new_filename = generate_unique_filename(upload_path, file_ext)
                file_path = os.path.join(upload_path, new_filename)
                
                file.save(file_path)
                response["mesaj"] = "Dosya başarıyla yüklendi"
                url = request.base_url.replace("/upload", "/")
                response["dosya"] = f"{url}{file_path}"
                response["basarili"] = True
                return jsonify(response), 200
            else:
                return jsonify(response), 200
        else:
            return jsonify(response), 200
    return jsonify(response), 200

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)