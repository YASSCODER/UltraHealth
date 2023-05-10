/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.l10n.ParseException;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.entities.Ingrediant;
import com.mycompany.myapp.entities.Plat;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;

/**
 *
 * @author helmi
 */
public class ServiceIngrediant {
    public ArrayList<Ingrediant> ingrediants;
    public static ServiceIngrediant instance ; 
    public boolean resultOK;
    private  ConnectionRequest req; 
    public static final String BASE_URL="http://127.0.0.1:8000/api";
 
 
 private ServiceIngrediant() {
        req = new ConnectionRequest() ; 
         }
    
    public static ServiceIngrediant getInstance() {
        if (instance == null)
        {
            instance = new ServiceIngrediant();
        }
         return instance;
    }
 
 public ArrayList<Ingrediant> parseIngrediant(String jsonText){
        try {
            ingrediants= new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> IngrediantListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            List<Map<String,Object>> list =(List<Map<String,Object>>) IngrediantListJson.get("root");
            for ( Map<String,Object> obj: list){
             Ingrediant p = new Ingrediant();
             float id = Float.parseFloat(obj.get("id").toString());
             p.setId((int)id);
             String titre= obj.get("titre").toString();
             p.setTitre(titre);
             float caloris = Float.parseFloat(obj.get("caloris").toString());
             p.setCaloris((int)caloris);
             float poids = Float.parseFloat(obj.get("poids").toString());
             p.setPoids((int) poids);
               System.out.println(p);
             ingrediants.add(p);
        } } 
           catch (IOException ex) {
//            Logger.getLogger(ServiceOeuvre.class.getName()).log(Level.SEVERE, null, ex); 
        } 
          return ingrediants;
 }
 
     public ArrayList<Ingrediant> getAllIngrediant(){
        String url = BASE_URL+"/ingrediant/list";
        req.setUrl(url);
        req.setPost(false);
                System.out.println(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                ingrediants = parseIngrediant(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return ingrediants;
    }
     
     
     
        public void Supprimer(int id) {
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(BASE_URL+"/deleteingrediantAPI/"+id);
        con.setPost(false);
        con.addResponseListener((evt) -> {
            System.out.println(con.getResponseData());

        });
        NetworkManager.getInstance().addToQueueAndWait(con);

    }
        
        
        
        
       public boolean addIngrediant (TextField tftitre,TextField tfcaloris,TextField tfpoids)
    { 

        String titre=tftitre.getText();
        String caloris=tfcaloris.getText();
        String poids = tfpoids.getText();
        

        String url = BASE_URL+"/addingrediantAPI?titre="+titre+"&caloris="+caloris+"&poids="+poids;
       
        String requestBody = "  {\"titre\":\""+titre+"\",\"caloris\":\""+caloris+"\",\"poids\":\""+poids+"\"}  ";

        req.setUrl(url);
        req.setPost(true);
        req.setHttpMethod("POST");
        req.setRequestBody(requestBody);

        System.out.println(req.getRequestBody());
        req.setContentType("application/json");

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
             }
    });
        System.out.println(""+resultOK);
       NetworkManager.getInstance().addToQueue(req);
        return resultOK;
    }
       
       
       
           public boolean updateIngrediant (String titre,int caloris,int poids,int id)
    { 
         
       String url = BASE_URL+"/editIngrediantAPI/"+id+"?titre="+titre+"&caloris="+caloris+"&poids="+poids;
        String requestBody = "  {\"titre\":\""+titre+"\",\"caloris\":\""+caloris+"\",\"poids\":\""+poids+"\"}  ";

        req.setUrl(url);
        req.setPost(true);
        req.setHttpMethod("POST");
        req.setRequestBody(requestBody);

        System.out.println(req.getRequestBody());
        req.setContentType("application/json");

       req.addResponseListener(new ActionListener<NetworkEvent>(){ 
           @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
             }
    });
        System.out.println(""+resultOK);
       NetworkManager.getInstance().addToQueue(req);
        return resultOK;
    }
           public ArrayList<Ingrediant> searchIngrediant(String query) {
    ArrayList<Ingrediant> results = new ArrayList<>();

    for (Ingrediant ingrediant : getAllIngrediant()) {
        if (ingrediant.getTitre().toLowerCase().contains(query.toLowerCase())) {
            results.add(ingrediant);
        }
    }

    return results;
}


}
