/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

import java.sql.Date;

/**
 *
 * @author Mega-PC
 */
public class Blog {
  private int id;
  private Date date;
  private String titre;
  private String description_b ;  

    public Blog() {
    }

    public Blog(int id, Date date, String titre, String description_b) {
        this.id = id;
        this.date = date;
        this.titre = titre;
        this.description_b = description_b;
    }

    public int getId() {
        return id;
    }

    public Date getDate() {
        return date;
    }

    public String getTitre() {
        return titre;
    }

    public String getDescription_b() {
        return description_b;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public void setDescription_b(String description_b) {
        this.description_b = description_b;
    }

    public void setCaloris(String text) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

}