package tr.com.biltekbilgisayar.teknikservis

import android.content.Intent
import android.os.Bundle
import io.flutter.embedding.android.FlutterActivity
import io.flutter.embedding.engine.FlutterEngine
import io.flutter.plugin.common.MethodChannel

class MainActivity : FlutterActivity(){
    private val CHANNEL = "teknikservis/notifications"
    private var methodChannel: MethodChannel? = null
    private var pendingNotificationTip: String? = null

    override fun configureFlutterEngine(flutterEngine: FlutterEngine) {
        super.configureFlutterEngine(flutterEngine)
        methodChannel = MethodChannel(flutterEngine.dartExecutor.binaryMessenger, CHANNEL)
        pendingNotificationTip?.let {
            methodChannel?.invokeMethod("notificationClicked", mapOf("tip" to it))
            pendingNotificationTip = null
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        handleIntent(intent)
    }

    override fun onNewIntent(intent: Intent) {
        super.onNewIntent(intent)
        setIntent(intent)
        handleIntent(intent)
    }

    private fun handleIntent(intent: Intent) {
        val tip = intent.getStringExtra("tip")
        if (tip != null) {
            // FlutterEngine hazır değilse intent'i sakla
            if (methodChannel != null) {
                methodChannel?.invokeMethod("notificationClicked", mapOf("tip" to tip))
            } else {
                // FlutterEngine hazır olunca çağırılacak şekilde sakla
                pendingNotificationTip = tip
            }
        }
    }
}
