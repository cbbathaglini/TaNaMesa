package com.studio.tanamesaapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import com.studio.tanamesaapp.acoes.mesa.CadastrarMesa;

public class MainActivity extends AppCompatActivity {

    Button btnCadastrarMesa;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        btnCadastrarMesa = (Button) findViewById(R.id.btn_cadastrarMesa);
        btnCadastrarMesa.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(MainActivity.this, CadastrarMesa.class));
            }
        });

    }
}
