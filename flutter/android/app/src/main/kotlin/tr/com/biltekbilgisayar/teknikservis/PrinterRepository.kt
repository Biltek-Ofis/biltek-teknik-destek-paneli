package tr.com.biltekbilgisayar.teknikservis

import android.content.Context
import android.util.Log
import org.json.JSONArray
import java.io.File

object PrinterRepository {
    private const val FILE_NAME = "biltek_printers.json"

    private fun getFile(context: Context): File {
        val file = File(context.applicationContext.filesDir, FILE_NAME)
        Log.d("PrinterRepository", "File path: ${file.absolutePath}")
        return file
    }

    fun savePrinters(context: Context, printers: List<PrinterConfig>) {
        val arr = JSONArray()
        printers.forEach { arr.put(it.toJson()) }
        val content = arr.toString()
        getFile(context).writeText(content)
        Log.d("PrinterRepository", "Saved ${printers.size} printer(s): $content")
    }

    fun loadPrinters(context: Context): List<PrinterConfig> {
        val file = getFile(context)
        Log.d("PrinterRepository", "File exists: ${file.exists()}, path: ${file.absolutePath}")
        if (!file.exists()) return emptyList()
        return try {
            val content = file.readText()
            Log.d("PrinterRepository", "File content: $content")
            val arr = JSONArray(content)
            (0 until arr.length()).map {
                PrinterConfig.fromJson(arr.getJSONObject(it))
            }
        } catch (e: Exception) {
            Log.e("PrinterRepository", "Load error: ${e.message}", e)
            emptyList()
        }
    }
}