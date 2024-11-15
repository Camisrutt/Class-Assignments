import java.security.Provider;
import java.security.Security;

public class demo4 {
    public static void main(String[] args) {
        Provider[] providers = Security.getProviders();
        for (int i = 0; i < Math.min(providers.length, 4); i++) {  // Output limited to 4 providers as required
            System.out.println(providers[i]);
            providers[i].forEach((key, value) -> System.out.println("\t" + key + ": " + value));
        }
    }
}
