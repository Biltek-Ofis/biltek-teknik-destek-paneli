package tr.com.biltekbilgisayar.teknikservis

import org.json.JSONObject

data class PrinterConfig(
    val id: String,
    val ip: String,
    val port: Int,
    val name: String
) {
    fun toJson(): JSONObject = JSONObject().apply {
        put("id", id)
        put("ip", ip)
        put("port", port)
        put("name", name)
    }

    companion object {
        fun fromJson(json: JSONObject) = PrinterConfig(
            id = json.getString("id"),
            ip = json.getString("ip"),
            port = json.getInt("port"),
            name = json.getString("name")
        )
    }
}