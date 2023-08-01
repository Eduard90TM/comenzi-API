<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Functia folosita pentru requestul de getAll
     * Aduce din baza de date toate resursele din model
     * In cazul nostru aduce din baza de date toate Orders ( comenzile )
     */
    public function index()
    {
        // creem o variabila in care sa stocam rezultatul query-ului
        // folosim numele sugestiv pentru resursa noastra la plural evident

        $orders = Order::all();
        // Order::all() reprezinta functia statica din clasa Order care este defapt un model, modelul Order
        // aceasta executa un SQL query, si anume Select * from 'orders';
        // dupa ce am adus din baza de date informatiile
        // le trimitem catre utilizator sub forma de JSON

        return response()->json($orders);
        // la response()->json('parametrul pentru data, ce trimitem inapoi', 'parametrul pentru status default 200');
        // *** ca sa vedeti toate status codes din HTTP, cautai pe mozila developer network http status codes
    }

    /**
     * Store a newly created resource in storage.
     * functia folosita pentru a salva un nou order in baza de date
     * primeste prin request, in cazul nostru BODY din requestul Postman, toate informatiile ce trebuie salvate in baza de date
     */
    public function store(Request $request)
    {
        // creem o variabila, si salvaz o referinta catre un obiect de tip Order
        $order = new Order();
        // asignam valori proprietatilor obiectului nostru
        // proprietatile obiectului nostru, sunt defapt coloanele din tabelul din baza de date
        $order->user_id = 1; // am pus 1 pentru ca user_id este o cheie straina, un foreign key
        // momentan nu avem useri implementati creati etc... si o sa folosesc pur simplu id-ul primului user ca test
        // daca nu avem user_id asignat fiind foreign-key nu o sa functioneze, testati si voi la fel creeati un user si folositi id-ul lui
        $order->total_value = $request->total_value;
        // am asignat proprietatii de total_value a obiectului nostru, care reprezinta tabelul din baza de date, la coloana total_value
        // valoarea primita din request sub numele de total_value, deci numele proprietatii obiectului primit din request este la fel cu cel din tabel
        // se poate sa fie diferit, dar noi incercam sa il pastram la fel pentru a fi mai usor de folosit
        $order->total_weight = $request->total_weight;
        $order->payment_method = $request->payment_method;

        $order->save(); // functia folosita pentru a salva obiectul in baza de date dupa ce am asignat valori tututor prorietatilor
        // in cazul nostru, dupa ce am asignat valori tuturor coloanelor din baza de date

        // dupa ce totul a fost salvat trimitem ca raspuns $order-ul si statusul 201
        // 201 reprezinta status code in HTTP pentru resource create ( vezi mozilla developer network HTTP status codes)
        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     * Folosita pentru a trimite ca raspuns json, un singur obiect/resursa/element/rand din tabelul din baza de date
     * Folosim id-ul unic al obiectului/produsului/resursei.. pentru a aduce toate informatiile lui
     */
    public function show(string $id)
    // php artisan, comanda folosita pentru a genera acest controller a setat gresit tipul si parametrul
    // au fost setat cu Modelul ca si tip si $order
    // dar defapt noi aici primit un string, adica tipul va fi string
    // si parametrul este de obicei numit $id
    // deci functia va fi show(string $id)
    {
        // prima data cautam in baza de date dupa $id -ul primit si vedem daca exista resursa noastra

        // initializam o variabila in care sa stocam rezultatul query-ului nostru
        $order = Order::find($id); // find cauta dupa parametrul dat in coloana de ID daca exista o resursa cu acel ID

        // verificam daca sa gasit o resursa in baza de date
        // in caz contrar trimitem un raspuns cu textul Not Found
        // si status code 404

        if (!$order) {
            return response()->json('Not Found', 404);
        }


        // daca totul este ok
        // trimitem order-ul gasit cu statusul 200
        return response()->json($order, 200);

    }

    /**
     * Update the specified resource in storage.
     * Este folosita pentru a modificat in baza de date o resursa folsind id-ul pentru a gasi resursa
     * si folosind corpul requestului, reqeust body pentru a prelua valorile
     */
    public function update(Request $request, string $id)
    // la fel ca la show
    // comanda artisan cand a generat controllerul la generat cu tipul si numele gresit al celui de al doilea parametru
    // si anume tipul trebuie sa fie string si numele $id
    // adica update(Request $request, string $id)
    {
        // inainte sa facem update
        // verificam da exista in baza de date o resursa cu id-ul specificat de noi
        // initializam o variabila in care sa stocam referinta catre rezultatul query-ului
        $order = Order::find($id); // find este folosit pentru a gasit o resursa in baza de date, care are aceeasi valoare la coloana ID
        // ca si valoarea parametrului dat de noi

        // in cazul in care nu gasim o resursa cu id-ul specifica
        // trimitem un raspuns json cu textul 'not found'
        // si codul 404 , cod http pentru not found

        if (!$order) {
            return response()->json('Not found', 404);
        }

        // daca toul este ok
        // modificam proprietatiile obiectului gasit care face referinta la tabelul din baza noastra de date
        // cu valorile primite in request
        $order->total_value = $request->total_value;
        $order->total_weight = $request->total_weight;
        $order->payment_method = $request->payment_method;

        // dupa ce am asignat toate valorile primite in request, proprietatilor obiectului nostru
        // trebuie sa salvam modificarile in baza de date

        $order->save();

        // dupa ce salvam trebuie sa trimitem obiectul cu noile valori modificate
        // catre utilizator sub forma de json

        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     * functia folosita pentru a sterge o resursa din baza de date folosind id-ul primit ca request
     */
    public function destroy(string $id)
    // php artisan a generat functia cu un parametru de tip model si numele gresit
    // noi avem nevoie de un parametru de tip string cu numele $id
    {
        // creem o variabila is stocam referinta catre
        // query-ul din baza de date care aduce resursa, obiectul care face referire la tabelul nostru

        $order = Order::find($id);

        // verificam daca exista

        if (!$order) {
            // daca nu exista raspundem cu json not found si cod 404
            return response()->json('Not found', 404);
        }

        // daca exista stergem resursa

        $order->delete();
        // si trimitem un raspuns gol cu status 204

        return response()->json('', 204);
        // 204 este codul pentru no content returne
        // vezi mozilla developer network http status codes
    }
}