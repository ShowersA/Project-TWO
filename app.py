import numpy as np
from flask import Flask, jsonify
from sqlalchemy import create_engine
# from sqlalchemy.ext.automap import automap_base
# from sqlalchemy.orm import Session
import psycopg2
import json
import pandas as pd
# from flask_cors import CORS
Database_URI = "postgres+psycopg2://postgres:postgres@localhost:5432/occdb"
engine = create_engine(Database_URI)


df = pd.read_sql("select * from occupation",engine).to_dict(orient="records")




# # reflect an existing database into a new model
# Base = automap_base()
# # reflect the tables
# Base.prepare(engine, reflect=True)

# # Save reference to the table
# Occupation = Base.classes.occupation

#################################################
# Flask Setup
#################################################
app = Flask(__name__)
# CORS(app, origins=r'http://localhost:8000')

#################################################
# Flask Routes
#################################################

@app.route("/")
def welcome():
    """List all available api routes."""
    return (
        f"Available Routes:<br/>"
        f"/api/v1.0/area_title<br/>"
        f"/api/v1.0/occ_title<br/>"
        f"/api/v1.0/tot_emp<br/>"
        f"/api/v1.0/h_mean<br/>"
        f"/api/v1.0/a_mean"
    )


@app.route("/data")
def data():

   


    

    return jsonify(df)





# @app.route("/data")
# def names():
#     # Create our session (link) from Python to the DB
#     session = Session(engine)

#     """Return a list of all passenger names"""
#     # Query all area_title
#     results = session.query(Occupation.area_title).all()

#     session.close()

#     # Convert list of tuples into normal list
#     all_names = list(np.ravel(results))

#     return jsonify(all_area_title)


# @app.route("/api/v1.0/occ_title")
# def passengers():
#     # Create our session (link) from Python to the DB
#     session = Session(engine)

#     """Return a list of passenger data including the name, age, and sex of each passenger"""
#     # Query all passengers
#     results = session.query(Passenger.name, Passenger.age, Passenger.sex).all()

#     session.close()

#     # Create a dictionary from the row data and append to a list of all_passengers
#     all_passengers = []
#     for name, age, sex in results:
#         passenger_dict = {}
#         passenger_dict["name"] = name
#         passenger_dict["age"] = age
#         passenger_dict["sex"] = sex
#         all_passengers.append(passenger_dict)

#     return jsonify(all_passengers)


if __name__ == '__main__':
    app.run(debug=True)