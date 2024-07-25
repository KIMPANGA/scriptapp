package com.example.eim_clients;

import android.annotation.SuppressLint;
import android.app.ActivityOptions;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.eim_clients.config.BD_connexion;
import com.example.eim_clients.config.ControleurEmailMotDePasse;
import com.example.eim_clients.config.PasswordValid;
import com.google.gson.Gson;
import com.google.gson.JsonArray;
import com.google.gson.JsonSyntaxException;

import java.util.HashMap;
import java.util.Map;

public class Login extends AppCompatActivity
{
    String URl_data=BD_connexion.BASE_URL;
    EditText email;
    EditText PWD;
    public void MessageToast(){
        Toast.makeText(this, "Mot de passe ou nom d'utilisateur Incorrecte",Toast.LENGTH_LONG)
                .show();
    }
    public void MessageToast(String mgs){
        Toast.makeText(this, mgs,Toast.LENGTH_LONG)
                .show();
    }
    public void Routes(Context context, Class Route,Bundle bundle){
        Intent intent=new Intent(context,Route);
        startActivity(intent,bundle);
    }

    public void MessageDialog(String Title,String Message,String Choix,String Choix1){

        new AlertDialog.Builder(this)
                .setTitle(Title)
                .setMessage(Message)
                .setNegativeButton(Choix,(new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        final String cr = Choix;
                    }
                })).setPositiveButton(Choix1, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        final String cr1 = Choix1;
                    }
                })
                .show();
    }

    @SuppressLint("ClickableViewAccessibility")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

          email = findViewById(R.id.TxtEmail);
          PWD = findViewById(R.id.TxtPWD);
        @SuppressLint({"MissingInflatedId", "LocalSuppress"}) Button btn_login = findViewById(R.id.BtnLogin);
        TextView textmail = findViewById(R.id.ValidateTextField);
        TextView textpwd = findViewById(R.id.ValidateTextField1);
        boolean isval=PasswordValid.isValidPassword(PWD.getText().toString());
        email.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                textmail.setVisibility(View.GONE);
                return false;
            }
        });
        PWD.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                textpwd.setVisibility(View.GONE);
                return false;
            }
        });
        btn_login.setOnClickListener(v -> {
            String emai = email.getText().toString();
            String pwd = PWD.getText().toString();

            if (emai.isEmpty() || pwd.isEmpty()) {
                try {
                    email.setText("");
                    PWD.setText("");
                    MessageToast();
                } catch (Exception ex) {
                    MessageToast(ex.getMessage());
                }

            } else {
                try {
                    ControleurEmailMotDePasse controleur = new ControleurEmailMotDePasse(email, PWD);
                    if (!controleur.estEmailValide()) {
                        textmail.setVisibility(View.VISIBLE);
                    }else if(isval){
                        textpwd.setVisibility(View.VISIBLE);
                    } else {
                        Agent(email.getText().toString(),PWD.getText().toString(),PWD.getText().toString());
                    }
                } catch (Exception ex) {
                    MessageDialog("Erreur survenu", ex.getMessage(), "Quitter", "OK");
                }
            }
        });
        TextView txt = findViewById(R.id.motpasseob);
        txt.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Login.this, passwordReset.class);
                startActivity(
                        intent
                );
            }
        });
        @SuppressLint({"MissingInflatedId", "LocalSuppress"}) TextView txt1 = findViewById(R.id.registerbtn);
        txt1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    Intent intent = new Intent(Login.this, Register_agents.class);
                    startActivity(intent);
                } catch (Exception ex) {
                    new AlertDialog.Builder(Login.this)
                            .setMessage(
                                    ex.getMessage()
                            ).show();
                }

            }
        });

        /*
        * EditText champEmail = findViewById(R.id.champEmail);
TextView compteurMotDePasse = findViewById(R.id.compteurMotDePasse);
EditText champMotDePasse = findViewById(R.id.champMotDePasse);

ControleurEmailMotDePasse controleur = new ControleurEmailMotDePasse(champEmail, compteurMotDePasse, champMotDePasse);

// Vérifier si l'e-mail est valide lors de la perte du focus du champ
champEmail.setOnFocusChangeListener(new View.OnFocusChangeListener() {
    @Override
    public void onFocusChange(View v, boolean hasFocus
*/
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }
    public boolean JsonValid(String json)
    {

        Boolean val= (Boolean) new Gson().fromJson(json, Object.class);
        return false;
    }
    public boolean Agent(String email, String telephone, String pwd){
        ProgressDialog pg = new ProgressDialog(Login.this);
        pg.setTitle("Login");
        pg.setIcon(R.drawable.baseline_circle_24);
        pg.setMessage("Veuillez Patientez svp!!!");
        pg.setCancelable(false);
        pg.show();

        StringRequest request=new StringRequest(Request.Method.POST, URl_data+"login.php", new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                pg.dismiss();
                try {
                    new Gson().fromJson(response, Object.class);
                    if(!response.isEmpty()){
                        new androidx.appcompat.app.AlertDialog.Builder(Login.this)
                                .setTitle("Login")
                                .setMessage("Bievenue à sala cash !!!")
                                .setCancelable(false)
                                .setNeutralButton("Ok", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        Intent intent=new Intent(Login.this, Agents.class);
                                        intent.putExtra("code_agent",email);
                                        intent.putExtra("JsonAgent",response);
                                        startActivity(intent);
                                    }
                                }).show();
                    }else{  new androidx.appcompat.app.AlertDialog.Builder(Login.this)
                            .setTitle("Login")
                            .setMessage(response)
                            .setCancelable(false)
                            .setNeutralButton("Ok", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {

                                }
                            }).show();}
                } catch (JsonSyntaxException e) {
                    new androidx.appcompat.app.AlertDialog.Builder(Login.this)
                            .setTitle("Login")
                            .setMessage("Nom d'utilisateur ou mot de passe incorrecte")
                            .setCancelable(false)
                            .setNeutralButton("Ok", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {

                                }
                            }).show();
                }

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                pg.dismiss();
                new androidx.appcompat.app.AlertDialog.Builder(Login.this)
                        .setTitle("Erreur survenu")
                        .setMessage(error.getMessage())
                        .show();
            }
        }){
            /**
             * @return
             * @throws AuthFailureError
             */
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> param=new HashMap<String, String>();
                param.put("email_agent",email);
                param.put("mot_passe_agent",pwd);
                return param;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(Login.this);
        queue.add(request);
        return true;
    }


}
