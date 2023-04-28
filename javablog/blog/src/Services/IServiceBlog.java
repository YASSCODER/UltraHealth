/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entities.Blog;
import java.sql.SQLException;
import javafx.collections.ObservableList;

/**
 *
 * @author User
 */
public interface IServiceBlog {
    public void AjouterBlog(Blog c);
    public ObservableList<Blog>AfficherBlog();
    public void supprimerBlog(int id);
    public void ModifierBlog(Blog c);
}
