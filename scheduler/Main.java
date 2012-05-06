
public class Main {


	public static void main(String args[]){
		try{
			
			RunTimeChecker rt = new RunTimeChecker(args[0]);
			rt.work();
			
		}catch(Exception e){
			e.printStackTrace();
		}
	}
	
}
