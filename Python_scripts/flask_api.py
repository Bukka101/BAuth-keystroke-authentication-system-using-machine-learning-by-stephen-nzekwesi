from flask import Flask, request
import os
import re
import pandas as pd
from bauth_functions import run_train
from bauth_functions import run_pred
from flask import jsonify

# Create a Flask application instance
app = Flask(__name__)

# Define a route for the home page
@app.route('/')
def home():
    return "Hello, World!"

# define route for train model
@app.route('/train', methods=['POST'])
def inspect_input():
# Inspect inputs. inspects supplied input to ascertain they are supposed as expected
# train model and save to file
# input: supplied input variables
# output: success Or fail safe
    try:
        # Get and handle variables from form data
        model_name = request.form.get('model_name').strip()
        model_type = request.form.get('model_type').strip()
        path = request.form.get('path').strip()

        if not isinstance(model_name, str) or not model_name:
            return jsonify({"error": "Model name must be a non-empty string."}), 400
        if not bool(re.match(r'^[a-zA-Z0-9_\-\.]+$', model_name)):
            return jsonify({"error": "Model name must not contain special characters."}), 400

        if model_type not in ["RF", "SVM"] or not model_type:
            return jsonify({"error": "Model type must be either 'RF' or 'SVM'."}), 400

        if not (path.endswith("/") or path.endswith("\\")):
            return jsonify({"error": "path must end with either '/' or '\\'."}), 400

        if not os.path.isabs(path) and os.access(path, os.W_OK):
            return jsonify({"error": "Invalid or non-writable system path."}), 400

        # Handle uploaded file
        if 'dataset' not in request.files:
            return jsonify({"error": "No dataset uploaded."}), 400

        dataset = request.files['dataset']

        if dataset.filename == '':
            return jsonify({"error": "Empty file name."}), 400

        if not dataset.filename.lower().endswith('.csv'):
            return jsonify({"error": "Invalid file format. Only CSV files are allowed."}), 400

        try:
            df = pd.read_csv(dataset)
            if df.empty:
                return jsonify({"error": "CSV file contains no data."}), 400
        except Exception:
            return jsonify({"error": "Invalid CSV file format."}), 400

        dataset.seek(0) # Reset dataset pointer

        # Run model training
        if run_train(model_name, dataset, model_type, path) ==  1:
            return jsonify({"message": "Model training successful."}), 200
        else:
            return jsonify({"error": "Model training failed."}), 500

    except Exception as e:
        return jsonify({"error": str(e)}), 500



# define route for prediction
@app.route('/predict', methods=['POST'])
def inspect_pred():
# Inspect inputs. inspects supplied input to ascertain they are supposed as expected
# run prediction
# input: supplied input and json data of keystroke
# output: predicted user Or fail safe
    try:
        if not request.is_json:
            return jsonify({"error": "Request must be JSON"}), 400

        data = request.get_json()

        if 'model_path' not in data:
            return jsonify({"error": "model path data must be present in json"}), 400

        prediction = run_pred(data)
        return jsonify({"prediction": prediction}), 200

    except Exception as e:
        return jsonify({"error": "Invalid JSON format"}), 400


# Run the app if this script is executed
if __name__ == '__main__':
    app.run(debug=True)

