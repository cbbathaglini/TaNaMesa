package com.studio.tanamesaapp;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;
import com.studio.tanamesaapp.R;


import org.json.JSONObject;

public class CadastrarMesa extends AppCompatActivity {

    Button btnCadastrar;
    EditText edtNumeroMesa;
    EditText edtNumLugaresMesa;

    private final String HOST = "http://10.0.2.2/TaNaMesa/public_html/controlador_rest.php?action_rest=cadastrar_mesa";




    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cadastrar_mesa);

        edtNumeroMesa = (EditText) findViewById(R.id.edt_numeroMesa);
        edtNumLugaresMesa = (EditText) findViewById(R.id.edt_numLugaresMesa);

        btnCadastrar = (Button) findViewById(R.id.btn_cadastrar);
        btnCadastrar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                final String numeroMesa = edtNumeroMesa.getText().toString();
                final String numLugaresMesa = edtNumLugaresMesa.getText().toString();
                final String situacaoMesa = "L";

                Log.d("ress", numeroMesa+","+numLugaresMesa+","+situacaoMesa);


                Ion.with(CadastrarMesa.this)
                        .load(HOST)
                        .setBodyParameter("numeroMesa",numeroMesa)
                        .setBodyParameter("numLugaresMesa",numLugaresMesa)
                        .setBodyParameter("situacaoMesa",situacaoMesa)
                        .asJsonObject()
                        .setCallback(new FutureCallback<JsonObject>() {
                            @Override
                            public void onCompleted(Exception e, JsonObject result) {
                                try {
                                    //e.printStackTrace();
                                    //Log.i("exxxxxxxxx", String.valueOf(e));

                                    //Log.i("errrrr", String.valueOf(result));
                                    //Log.i("resul", result.toString());

                                    if (result.get("resultado").getAsString().equals("true")) {
                                        //Log.i("RESULTADO: ", result.get("resultado").getAsString());
                                        //int idRetornado = Integer.parseInt(result.get("ID").getAsString());

                                        //Toast.makeText(MainActivity.this, "Salvo com sucesso, id " + idRetornado,
                                        //        Toast.LENGTH_LONG).show();
                                        Toast.makeText(CadastrarMesa.this, "Salvo com sucesso",
                                                Toast.LENGTH_LONG).show();
                                    } else {
                                        Toast.makeText(CadastrarMesa.this, "Ocorreu um erro ao salvar",
                                                Toast.LENGTH_LONG).show();
                                    }
                                }
                                catch (Exception ex){
                                    Log.i("error",String.valueOf(ex));
                                    Toast.makeText(getApplicationContext(),"Please check your Internet connection",Toast.LENGTH_LONG).show();
                                }
                            }
                        });
            }
        });

    }
}
